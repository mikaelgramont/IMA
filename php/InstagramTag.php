<?php
class InstagramTag {
	private $_cacheKey = 'photos';

    const CACHE_DURATION = 60 * 5;

	public function __construct($tag, $pool, $blacklist, $useCache, $cacheId)
	{
		$this->_tag = $tag;
		$this->_pool = $pool;
		$this->_blacklist = $blacklist;
		$this->_useCache = $useCache;
		$this->_cacheId = $cacheId;
        $this->_additionalTag = '';
	}

	private function _scrape()
	{
		$insta_source = @file_get_contents('https://www.instagram.com/explore/tags/'.$this->_tag);
    if (!$insta_source) {
      return array();
    }
    $shards = explode('window._sharedData = ', $insta_source);
		$insta_json = explode(';</script>', $shards[1]); 
		$insta_array = json_decode($insta_json[0], TRUE);
		$photosRaw = $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
		$photos = array();
		foreach ($photosRaw as $photo) {
		    if (!isset($photo['node']['edge_media_to_caption']['edges'][0])) {
		        continue;
            }
            $output = new stdClass();
            $output->id = $photo['node']['id'];
            $output->title = $photo['node']['edge_media_to_caption']['edges'][0]['node']['text'];
            $output->src = $photo['node']['thumbnail_src'];
            $output->timestamp = $photo['node']['taken_at_timestamp'];
            $output->shortcode = $photo['node']['shortcode'];
            $output->commentCount = $photo['node']['edge_media_to_comment']['count'];
            $output->likeCount = $photo['node']['edge_liked_by']['count'];
            $output->isVideo = $photo['node']['is_video'];

            if (in_array($output->id, $this->_blacklist)) {
                continue;
            }

            $photos[] = $output;
		}
		return $photos;
	}

	public function getPhotos()
	{
		$cacheItem = $this->_pool->getItem($this->_cacheId);

		if ($this->_useCache) {
			if ($cacheItem->isMiss()) {
				$photos = $this->_scrape();
				$cacheItem->lock();
				$cacheItem->set($photos);
				$cacheItem->expiresAfter(self::CACHE_DURATION);
				$this->_pool->save($cacheItem);
			} else {
				$photos = $cacheItem->get();
			}
		} else {
			$photos = $this->_scrape();
		}

		if ($this->_additionalTag) {
		    $photos = array_filter($photos, function($photo) {
		        return strpos($photo->title, '#'.$this->_additionalTag) !== false;
            }, ARRAY_FILTER_USE_BOTH);
        }
		return $photos;
	}

	public function enforceTagPresence($additionalTag) {
	    $this->_additionalTag = $additionalTag;
    }
}