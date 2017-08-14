<?php
class ResultCategory
{
	private $_name;

	private $_rankings = array();

	public function __construct($name) {
		$this->_name = $name;
	}

	public function addRanking(ResultRanking $ranking)
	{
		$this->_rankings[] = $ranking;
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