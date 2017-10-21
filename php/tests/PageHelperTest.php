<?php
declare(strict_types=1);

require('../PageHelper.php');

use PHPUnit\Framework\TestCase;

final class PageHelperTest extends TestCase
{
	private $_baseUrl = "http://www.local.dev/IMA/public/";

	public function testUrlWithSingleSection()
	{
		list($pageId, $params) = PageHelper::getPageIdAndParams($this->_baseUrl, "http://www.local.dev/IMA/public/results");
		$this->assertEquals("results", $pageId);
		$this->assertEquals(array(), $params);
	}

	public function testUrlWithTwoSections()
	{
		list($pageId, $params) = PageHelper::getPageIdAndParams($this->_baseUrl, "http://www.local.dev/IMA/public/results/2016");
		$this->assertEquals("results", $pageId);
		$this->assertEquals(array("2016"), $params);		
	}
}