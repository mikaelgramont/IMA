#!/usr/bin/env php
<?php
if (php_sapi_name() != 'cli') {
  throw new Exception('This application must be run on the command line.');
}

require_once __DIR__ . '/../php/config-main.php';
require_once 'Helpers.php';

// Load previously authorized credentials from a file.
if (file_exists(CREDENTIALS_PATH)) {
	printf ("File exists\n");
	exit();
}

Helpers::storeInitialAccessToken();