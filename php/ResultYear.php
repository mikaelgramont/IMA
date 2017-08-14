<?php
class ResultYear
{
	private $_year;

	private $_entries = array();

	public function __construct($year) {
		$this->_year = $year;
	}

	public function addEntry(ResultEntry $entry)
	{
		$this->_entries[] = $entry;
	}

	public function getYear()
	{
		return $this->_year;
	}

	public function getEntries()
	{
		return $this->_entries;
	}
}