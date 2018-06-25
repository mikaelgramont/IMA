<?php
class InstagramTag {
	private $_cacheKey = 'photos';

	public function __construct($tag, $pool, $blacklist, $useCache, $cacheId)
	{
		$this->_tag = $tag;
		$this->_pool = $pool;
		$this->_blacklist = $blacklist;
		$this->_useCache = $useCache;
		$this->_cacheId = $cacheId;
	}

	private function _scrape()
	{
		$insta_source = file_get_contents('https://instagram.com/explore/tags/'.$this->_tag);
		$shards = explode('window._sharedData = ', $insta_source);
		$insta_json = explode(';</script>', $shards[1]); 
		$insta_array = json_decode($insta_json[0], TRUE);
		$photosRaw = $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
		$photos = array();
		foreach ($photosRaw as $photo) {
			if (in_array($photo['node']['id'], $this->_blacklist)) {
				continue;
			}
			$photos[] = $photo['node'];
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