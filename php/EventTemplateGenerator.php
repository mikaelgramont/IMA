<?php
class EventTemplateGenerator
{
	private $_event;
	private $_outputPath;
	private $_fullOutput = "";	

	public function __construct(EventEntry $event, $path)
	{
		$this->_event = $event;
		$this->_outputPath = $path;
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

		$img = "";
		if ($country) {
			$src = Utils::getFlagFileForCountry($country);
			if ($src) {
				$img = "<img src=\"$src\" class=\"country-flag big\">\n";
			}
		}


		$out =  "<section>\n";
		$out .= "\t<h2 class=\"display-font\">$name {$img}</h2>\n";
		$out .= "\t<p class=\"event-date-location\">\n";
		$out .= "\t<span class=\"\">$date</span> <span class=\"location\">$location, $country</span>\n";
		$out .= "\t</p>\n";
		$out .= "\t<p class=\"paragraph description\">$description</p>\n";
		if ($website) {
			$out .= "\t<p class=\"website\"><a href=\"$website\">More information</a></p>\n";
		}
		$out .= "\t<p class=\"contact\">$contact</p>\n";

		$out .= "</section>\n";
		$this->_fullOutput = $out;
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

}