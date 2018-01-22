<?php
class NewsletterContentList
{
	public function __construct(array $content, $currentTime)
	{
		$this->content = $content;
		$this->currentTime = $currentTime;
	}

	public function __toString()
	{
		return json_encode($this, JSON_PRETTY_PRINT);
	}
}