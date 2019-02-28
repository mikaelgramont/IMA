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
				'skipTitleInHead' => true,
			],
			(object) [
				'title' => 'Location',
				'url' => 'location',
				'file' => 'location.php',
				'headerClass' => 'location',
			],
			(object) [
				'title' => 'Competition',
				'url' => 'competition',
				'file' => 'competition.php',
				'headerClass' => 'competition',
			],
			(object) [
				'title' => 'Organizers',
				'url' => 'organizers',
				'file' => 'organizers.php',
				'headerClass' => 'organizers',
			],
			(object) [
				'title' => 'Registration',
				'url' => 'registration',
				'file' => 'registration.php',
				'headerClass' => 'registration',
			]
    );
	}
}