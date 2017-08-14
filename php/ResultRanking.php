<?php
class ResultRanking
{
	private $_firstName;

	private $_lastName;

	private $_position;

	public function __construct($firstName, $lastName, $position) {
		$this->_firstName = $firstName;
		$this->_lastName = $lastName;
		$this->_position = $position;
	}

	public function getName()
	{
		return $this->_firstName . " " . $this->_lastName;
	}

	public function getPosition()
	{
		return $this->_position;
	}
}