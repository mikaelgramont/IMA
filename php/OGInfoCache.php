<?php
class OGInfoCache
{
	private static $_instance;

	private $_filePath = "";

	private $_entries = array();

	private $_isDirty = false;

	public static function getInstance($filePath = "") {
		if (empty(self::$_instance)) {
			if (empty($filePath)) {
				throw new Exception("You must specify a file path when instantiating OGInfoCache");
			}
			self::$_instance = new OGInfoCache($filePath);
		}

		return self::$_instance;
	}

	protected function __construct($filePath) {
		$this->_filePath = $filePath;

		if (!is_readable($this->_filePath)) {
			throw new Exception("Disk file must be readable: ". $this->_filePath);
		}
		$this->_readFromDisk();
	}

	private function _hash($string) {
		return hash('ripemd160', $string);
	}

	private function _readFromDisk()
	{
		$json = file_get_contents($this->_filePath);
		$this->_entries = json_decode($json, true);
		//die('<pre>'.var_export($this->_entries, true).'</pre>');
	}

	public function setEntryFor($url, $title, $image)
	{
		$this->_isDirty = true;

		$entry = array(
			'title' => $title,
			'image' => $image
		);
		$hash = $this->_hash($url);
		
		$this->_entries[$hash] = $entry;
	}

	public function hasEntryFor($url)
	{
		$hash = $this->_hash($url);
		return isset($this->_entries[$hash]);
	}

	public function getEntryFor($url)
	{
		$hash = $this->_hash($url);
		$entry = $this->_entries[$hash];

		$obj = new stdClass();
		$obj->title = $entry['title'];
		$obj->image = $entry['image'];
		return $obj;
	}

	public function isDirty()
	{
		return $this->_isDirty;
	}

	public function writeToDisk()
	{
		if (!is_writable($this->_filePath)) {
			throw new Exception("Disk file must be writable: ". $this->_filePath);
		}
		$json = json_encode($this->_entries);
		file_put_contents($this->_filePath, $json);
	}
}