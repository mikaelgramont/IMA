<?php
class EventTemplateGenerator
{
	private $_event;
	private $_outputPath;
	private $_fullOutput = "";	
	private $_resultsByPath = array();
	private $_logger = "";	

	public function __construct(EventEntry $event, $path, Logger $logger)
	{
		$this->_event = $event;
		$this->_outputPath = $path;
		$this->_logger = $logger;
	}

	public function buildHTML(Google_Service_Drive $driveService)
	{
		$name = Utils::escape($this->_event->getName());
		$date = $this->_event->getDisplayDate();
		$location = Utils::escape($this->_event->getLocation());
		$country = Utils::escape($this->_event->getCountry());
		$description = Utils::escape($this->_event->getDescription());
		$website = Utils::escape($this->_event->getWebsite());
		$contact = Utils::escape($this->_event->getContact());

		$entryAnchorName = $this->_getAnchorName();
		$url =  'events/' . $entryAnchorName;

		$logMsg = "Building HTML for $name... ";

		$img = "";
		if ($country) {
		
			$src = Utils::getFlagFileForCountry($country);
			if ($src) {
				$img = "<img src=\"$src\" class=\"country-flag big\">\n";
			}
		}

		$out =  "<section class=\"event\">\n";
		$out .= "\t<h2 class=\"display-font\">$name {$img}\n";
		$out .= "\t\t<a class=\"link-icon\" href=\"$url\"></a>\n";
		$out .= "\t</h2>\n";
		$out .= "\t<p class=\"event-date-location\">\n";
		$out .= "\t<span class=\"\">$date</span><span aria-hidden=\"true\"> - </span><span class=\"location\">$location, $country</span>\n";
		$out .= "\t</p>\n";
		$out .= "\t<p class=\"paragraph description\">$description</p>\n";
		if ($contact) {
			$out .= "\t<p class=\"contact\">Contact: $contact</p>\n";
		}
		if ($website) {
			$out .= "\t<p class=\"website\"><a href=\"$website\">More information</a></p>\n";
		}

		$out .= "</section>\n";
		$this->_fullOutput = $out;

		$this->_logger->log($logMsg . " ok.");
	}

	public function getFullOutput()
	{
		return $this->_fullOutput;
	}

	public function saveToDisk($fullOutput)
	{
		$fullPath = $this->_outputPath . 'events.php';
		file_put_contents($fullPath, $fullOutput);
	}

	public function saveIndividualEventToDisk()
	{
		$eventPath = $this->_outputPath . $this->_getAnchorName() . '.php';
		file_put_contents($eventPath, $this->_fullOutput);
	}

	private function _getAnchorName()
	{
		$name = Utils::cleanStringForUrl($this->_event->getName());
		if (!is_numeric(substr($name, 0, 1))) {
			$name = $this->_event->getFirstDayYear() . '-' . $name;
		}

		return $name;
	}
}