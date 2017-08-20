<?php
class Pages
{
	public static function getList()
	{
		return array(
			(object) [
				'title' => 'Home',
				'url' => '',
				'file' => 'home.php',
				'headerClass' => 'home',
			],
			(object) [
				'title' => 'Events',
				'url' => 'events',
				'file' => 'events.php',
				'headerClass' => 'calendar',
			],
			(object) [
				'title' => 'results',
				'url' => 'results',
				'file' => 'results.php',
				'headerClass' => 'results',
			],
			(object) [
				'title' => 'Organizers',
				'url' => 'organizers',
				'file' => 'organizers.php',
				'headerClass' => 'organizers',
			],
			(object) [
				'title' => 'about',
				'url' => 'about',
				'file' => 'about.php',
				'headerClass' => 'about',
			],
		);
	}
}