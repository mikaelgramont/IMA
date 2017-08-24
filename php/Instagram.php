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
		$photosRaw = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
		$photos = array();
		foreach ($photosRaw as $photo) {
			if (in_array($photo['code'], $this->_blacklist)) {
				continue;
			}
			$photos[] = $photo;
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