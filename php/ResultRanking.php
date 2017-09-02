<?php
class ResultRanking
{
	private $_firstName;

	private $_lastName;

	private $_position;

	private $_country;

	public function __construct($position, $firstName, $lastName, $country) {
		$this->_firstName = strtolower($firstName);
		$this->_lastName = strtolower($lastName);
		$this->_position = $position;
		$this->_country = strtolower($country);
	}

	public function getFullName()
	{
		return ucfirst($this->_firstName) . " " . ucfirst($this->_lastName);
	}

	public function getPosition()
	{
		return $this->_position;
	}

	public function getCountry()
	{
		return $this->_country;
	}

	public function getLogText()
	{
		return <<<TXT
		Ranking {$this->_position} {$this->_firstName} {$this->_lastName} {$this->_country}

TXT;
	}
}