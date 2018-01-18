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
				'title' => 'Events',
				'url' => 'events',
				'file' => 'events.php',
				'headerClass' => 'calendar',
			],
			(object) [
				'title' => 'Results',
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
				'title' => 'About',
				'url' => 'about',
				'file' => 'about.php',
				'headerClass' => 'about',
			],
			(object) [
				'title' => 'Admin',
				'url' => 'admin',
				'file' => 'admin.php',
				'skipMenuEntry' => true,
			],
			(object) [
				'title' => '',
				'url' => 'perform-update',
				'file' => 'perform-update.php',
				'skipMenuEntry' => true,
				'noContent' => true
			],
			(object) [
				'title' => '',
				'url' => 'done-updating',
				'file' => 'done-updating.php',
				'skipMenuEntry' => true
			],
			(object) [
				'title' => 'News',
				'url' => 'news',
				'file' => 'news.php',
				'skipMenuEntry' => true,
			],
			(object) [
				'title' => 'Subscribe to the IMA newsletter.',
				'url' => 'newssletter',
				'file' => 'newsletter-subscription.php',
				'skipMenuEntry' => true,
			],
		);
	}
}