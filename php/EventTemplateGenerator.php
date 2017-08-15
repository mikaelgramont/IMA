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

		$out =  "<section>\n";
		$out .= "\t<h2>$name</h2>\n";
		$out .= "\t<p class=\"event-date\">$date</p>\n";
		$out .= "\t<p class=\"location\">$location ($country)</p>\n";
		$out .= "\t<p class=\"description\">$description</p>\n";
		$out .= "\t<p class=\"website\">$website</p>\n";
		$out .= "\t<p class=\"contact\">$contact</p>\n";

		$out .= "</section>\n";
		$this->_fullOutput = $out;
	}

	public function getFullOutput()
	{
		return $this->_fullOutput;
	}

	public function saveToDisk()
	{
		$fullPath = $this->_outputPath . 'events.php';
		file_put_contents($fullPath, $this->_fullOutput);
	}

}