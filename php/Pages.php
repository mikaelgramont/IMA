<?php
class Pages
{
	public static function getList()
	{
		return array(
			(object) [
				'title' => '',
				'url' => '',
				'file' => 'home.php'
			],
			(object) [
				'skipMenuEntry' => true,
				'title' => 'results',
				'url' => 'results',
				'file' => 'results.php'
			],
		);
	}
}