<?php
class Logger
{
	protected $_log = array();

	public function log($content) {
		$this->_log[] = $content;
	}

	public function dump()
	{
		return implode("\n", $this->_log());
	}

	public function dumpHtml()
	{
		return "<p>" . implode("</p></p>", $this->_log) . "</p>"; 
	}

	public function reset()
	{
		$this->_log = array();
	}
}