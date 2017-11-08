<?php
class EventEntry
{
	private $_values;

	const COUNTRY_COLUMN = 2; 			// C
	const NAME_COLUMN = 3;				// D
	const FIRST_DAY_COLUMN = 4;			// E
	const LAST_DAY_COLUMN = 5;			// F
	const LOCATION_COLUMN = 6;			// G
	const WEBSITE_COLUMN = 7;			// H
	const DESCRIPTION_COLUMN = 8;		// I
	const ORGANISER_CONTACT_COLUMN = 9;	// J
	const POSTER_COLUMN = 10;			// K
	const CHECKED_COLUMN = 11;			// L

	public function __construct($values)
	{
		$this->_values = $values;
	}

	public function getName()
	{
		return $this->_values[self::NAME_COLUMN];
	}

	public function getPosterFileUrlForDownload(Google_Service_Drive $driveService)
	{
		$id = $this->getPosterFileId();
		if (!$id) {
			return "";
		}
		$optParams = array(
			"fields" => "webContentLink"
		);
		$results = $driveService->files->get($id, $optParams);
		return $results["webContentLink"];
	}

	public function getPosterFileId()
	{
		// https://drive.google.com/open?id=0B_hhYXBytBOhTmt6eEVpS3MxaTg
		$fileId = $this->_values[self::POSTER_COLUMN];

		if (!$fileId) {
			return "";
		}
		$parts = explode("=", $fileId);
		if (sizeof($parts) != 2) {
			return "";
		}
		return $parts[1];
	}

	public function getDisplayDate()
	{
		// Single day  Aug 26 2017
		if ($this->_values[self::FIRST_DAY_COLUMN] == $this->_values[self::LAST_DAY_COLUMN] ||
			$this->_values[self::LAST_DAY_COLUMN] == "") {
			return $this->getFirstDayDate();
		}

		// Several days in a row, same month Aug 26-27 2017
		if (date("m-Y", $this->getFirstDayTimeStamp()) == date("m-Y", $this->getLastDayTimeStamp())) {
			$month = date("F", $this->getFirstDayTimeStamp());
			$day1 = date("d", $this->getFirstDayTimeStamp());
			$day2 = date("d", $this->getLastDayTimeStamp());
			$year = date("Y", $this->getFirstDayTimeStamp());
			return "$month {$day1}-{$day2} $year";
		}

		// Several days in a row, over two months Aug 31 - Sep 1 2017
		if (date("m", $this->getFirstDayTimeStamp()) != date("m", $this->getLastDayTimeStamp())) {
			$month1 = date("F", $this->getFirstDayTimeStamp());
			$day1 = date("d", $this->getFirstDayTimeStamp());

			$month2 = date("F", $this->getLastDayTimeStamp());
			$day2 = date("d", $this->getLastDayTimeStamp());

			$year = date("Y", $this->getFirstDayTimeStamp());
			return "$month1 $day1 - $month2 $day2 $year";
		}

		return "date";
	}

	public function getFirstDayYear()
	{
		return date("Y", $this->getFirstDayTimeStamp());
	}

	public function getFirstDayTimeStamp()
	{
		if (!isset($this->_values[self::FIRST_DAY_COLUMN])) {
			return "";
		}
		return $this->_getTimeStamp($this->_values[self::FIRST_DAY_COLUMN]);
	}

	public function getLastDayTimeStamp()
	{
		if (!isset($this->_values[self::LAST_DAY_COLUMN])) {
			return "";
		}
		return $this->_getTimeStamp($this->_values[self::LAST_DAY_COLUMN]);
	}

	private function _getTimeStamp($date)
	{
		$parts = date_parse_from_format("m/d/Y", $date);
		$time = mktime(0, 0, 0, $parts['month'], $parts['day'], $parts['year']);
		return $time;
	}

	public function getFirstDayDate()
	{
		if (!isset($this->_values[self::LAST_DAY_COLUMN])) {
			return "";
		}
		return $this->_formatDate($this->_values[self::FIRST_DAY_COLUMN]);
	}

	public function getLastDayDate()
	{
		if (!isset($this->_values[self::LAST_DAY_COLUMN])) {
			return "";
		}
		return $this->_formatDate($this->_values[self::LAST_DAY_COLUMN]);
	}

	private function _formatDate($date)
	{
		$time = $this->_getTimeStamp($date);
		return date("F d Y", $time);
	}

	public function getLocation()
	{
		return isset($this->_values[self::LOCATION_COLUMN]) ? $this->_values[self::LOCATION_COLUMN] : "";
	}

	public function getCountry()
	{
		return isset($this->_values[self::COUNTRY_COLUMN]) ? $this->_values[self::COUNTRY_COLUMN] : "";
	}

	public function getDescription()
	{
		return isset($this->_values[self::DESCRIPTION_COLUMN]) ? $this->_values[self::DESCRIPTION_COLUMN] : "";
	}

	public function getContact()
	{
		return isset($this->_values[self::ORGANISER_CONTACT_COLUMN]) ? $this->_values[self::ORGANISER_CONTACT_COLUMN] : "";
	}

	public function getWebsite()
	{
		return isset($this->_values[self::WEBSITE_COLUMN]) ? $this->_values[self::WEBSITE_COLUMN] : "";
	}
}