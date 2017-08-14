<?php
class ResultEntry
{
	private $_name;

	private $_categories = array();

	public function __construct($name) {
		$this->_name = $name;
	}

	public function addCategory(ResultCategory $category)
	{
		$this->_categories[] = $category;
	}

	public function getCategories()
	{
		return $this->_categories;
	}

	public function getName()
	{
		return $this->_name;
	}
}