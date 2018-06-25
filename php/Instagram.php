<?php
class Instagram {
	private $_cacheKey = 'photos';

	public function __construct($name, $pool, $blacklist, $useCache)
	{
		$this->_name = $name;
		$this->_pool = $pool;
		$this->_blacklist = $blacklist;
		$this->_useCache = $useCache;
	}

	private function _scrape()
	{
		$insta_source = file_get_contents('https://instagram.com/'.$this->_name);
		$shards = explode('window._sharedData = ', $insta_source);
		$insta_json = explode(';</script>', $shards[1]); 
		$insta_array = json_decode($insta_json[0], TRUE);
		$photosRaw = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
		$photos = array();
		foreach ($photosRaw as $photo) {
		    $output = new stdClass();
		    $output->id = $photo['node']['id'];
		    $output->title = $photo['node']['edge_media_to_caption']['edges'][0]['node']['text'];
		    $output->src = $photo['node']['thumbnail_src'];
		    $output->timestamp = $photo['node']['taken_at_timestamp'];
		    $output->shortcode = $photo['node']['shortcode'];
            $output->commentCount = $photo['node']['edge_media_to_comment']['count'];
            $output->likeCount = $photo['node']['edge_liked_by']['count'];

			if (in_array($output->id, $this->_blacklist)) {
				continue;
			}

			$photos[] = $output;
		}
		return $photos;
	}

	public function getPhotos()
	{
		$cacheItem = $this->_pool->getItem('instagram');

		if ($this->_useCache) {
			if ($cacheItem->isMiss()) {
				$photos = $this->_scrape();
				$cacheItem->lock();
				$cacheItem->set($photos);
				$cacheItem->expiresAfter(24 * 3600 * 2);
				$this->_pool->save($cacheItem);
			} else {
				$photos = $cacheItem->get();
			}
		} else {
			$photos = $this->_scrape();
		}
		return $photos;
	}
}