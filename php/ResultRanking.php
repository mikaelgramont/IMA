<?php
class ResultRanking
{
	private $_firstName;

	private $_lastName;

	private $_position;

    private $_country;

    private $_points;

    private $_time;

	public function __construct($position, $firstName, $lastName, $country, $points, $time) {
		$this->_firstName = strtolower($firstName);
		$this->_lastName = strtolower($lastName);
		$this->_position = $position;
		$this->_country = strtolower($country);
        $this->_points = strtolower($points);
        $this->_time = strtolower($time);
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

    public function hasPoints()
    {
        return $this->_points !== 'null';
    }

    public function getPoints()
    {
        return $this->_points;
    }

    public function hasTime()
	{
		return $this->_time !== 'null';
	}

    public function getTime()
	{
		return $this->_time;
	}

	public function getColumnCount() {
	    $count = 2;
	    if ($this->hasPoints()) {
	        $count += 1;
        }
	    if ($this->hasTime()) {
	        $count += 1;
        }
        return $count;
    }

	public function getLogText()
	{
		return <<<TXT
		Ranking {$this->_position} {$this->_firstName} {$this->_lastName} {$this->_country}  {$this->_time}

TXT;
	}
}