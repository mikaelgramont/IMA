<?php
class ResultEntry
{
	private $_year;

	private $_id;

	private $_name;

	private $_description;

	private $_categories = array();

	public function __construct($year, $id, $name, $description) {
		$this->_year = $year;
		$this->_id = $id;
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

	public function getYear()
	{
		return $this->_year;
	}


	public function getId()
	{
		return $this->_id;
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