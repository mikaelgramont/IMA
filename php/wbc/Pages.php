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
				'title' => 'Venue',
				'url' => 'venue',
				'file' => 'venue.php',
				'headerClass' => 'location',
			],
			(object) [
				'title' => 'Competition',
				'url' => 'competition',
				'file' => 'competition.php',
				'headerClass' => 'competition',
			],
			(object) [
				'title' => 'Contact',
				'url' => 'contact',
				'file' => 'contact.php',
				'headerClass' => 'contact',
			],
			(object) [
				'title' => 'Registration',
				'url' => 'registration',
				'file' => 'registration.php',
				'headerClass' => 'registration',
			],
			(object) [
        'title' => 'Home',
        'url' => 'paypal-transaction-complete',
        'file' => 'paypal-transaction-complete.php',
        'skipMenuEntry' => true,
        'noContent' => true,
      ],
    );
	}
}