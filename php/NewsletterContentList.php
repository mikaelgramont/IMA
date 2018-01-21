<?php
class NewsletterContentList
{
	public function __construct(array $content, $dateFrom = '', $dateTo = '', $showUsed = false, $showHidden = false, $onlyShowCategory = '', $fromPoster = "")
	{
		$this->content = $content;
		$this->dateFrom = $dateFrom;
		$this->dateTo = $dateTo;
		$this->showUsed = $showUsed;
		$this->showHidden = $showHidden;
		$this->onlyShowCategory = $onlyShowCategory;
		$this->fromPoster = $fromPoster;
	}

	public function __toString()
	{
		return json_encode($this, JSON_PRETTY_PRINT);
	}
}