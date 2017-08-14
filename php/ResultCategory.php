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

	public function getRankings()
	{
		return $this->_rankings;
	}

	public function getName()
	{
		return $this->_name;
	}	
}