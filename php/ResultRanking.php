<?php
class ResultRanking
{
	private $_firstName;

	private $_lastName;

	private $_position;

	public function __construct($position, $firstName, $lastName) {
		$this->_firstName = $firstName;
		$this->_lastName = $lastName;
		$this->_position = $position;
	}

	public function getFullName()
	{
		return $this->_firstName . " " . $this->_lastName;
	}

	public function getPosition()
	{
		return $this->_position;
	}
}