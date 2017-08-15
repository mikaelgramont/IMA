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
				'title' => 'Public documents',
				'url' => 'public-documents',
				'file' => 'documents.php'
			],
			(object) [
				'title' => 'Events',
				'url' => 'events',
				'file' => 'events.php'
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