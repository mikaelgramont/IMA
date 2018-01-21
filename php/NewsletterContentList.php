<?php
class NewsletterContentList
{
	public function __construct(array $content, array $issues)
	{
		$this->content = $content;
		$this->issues = $issues;
	}

	public function __toString()
	{
		return json_encode($this, JSON_PRETTY_PRINT);
	}
}