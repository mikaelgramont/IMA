<?php
class ResultEntry
{
	private $_name;

	private $_description;

	private $_categories = array();

	public function __construct($name, $description) {
		$this->_name = $name;
		$this->_description = $description;
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

	public function getDescription()
	{
		return $this->_description;
	}
}