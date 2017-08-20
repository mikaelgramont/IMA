<?php
class ResultRanking
{
	private $_firstName;

	private $_lastName;

	private $_position;

	private $_country;

	public function __construct($position, $firstName, $lastName, $country) {
		$this->_firstName = $firstName;
		$this->_lastName = $lastName;
		$this->_position = $position;
		$this->_country = $country;
	}

	public function getFullName()
	{
		return $this->_firstName . " " . $this->_lastName;
	}

	public function getPosition()
	{
		return $this->_position;
	}

	public function getCountry()
	{
		return $this->_country;
	}
}