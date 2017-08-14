<?php
class ResultEntry
{
	private $_location;

	private $_categories = array();

	public function __construct($location) {
		$this->_location = $location;
	}

	public function addCategory(ResultCategory $category)
	{
		$this->_categories[] = $category;
	}

	public function getCategories()
	{
		return $this->_categories;
	}

	public function getLocation()
	{
		return $this->_location;
	}
}