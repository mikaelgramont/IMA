<?php
set_include_path(__DIR__.'/../php/:'.__DIR__.'/../php/vendor/tedivm/stash/src/');
require_once 'vendor/autoload.php';


define('DEBUG', true);

/* Google client API constants */
define('APPLICATION_NAME', 'IMA Website');
define('CREDENTIALS_PATH', __DIR__ . '/.credentials/credentials.json');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
define('CACHE_PATH', __DIR__ . '/../php/cache/');
define('RESULTS_CACHE_PATH', 'results/');

// If modifying these scopes, delete your previously saved credentials
// at CREDENTIALS_PATH
define('SCOPES', implode(' ', array(
  Google_Service_Drive::DRIVE_METADATA_READONLY,
  Google_Service_Sheets::SPREADSHEETS_READONLY
 )));

// The ID of the folder containing public documents.
define('PUBLIC_DOCUMENTS_FOLDER_ID', '0B1zQszUhxFKDVlV6TWZ3UldYRmM');
define('RESULTS_FOLDER_ID', '0B1zQszUhxFKDbjVvSjJQQ05IbkU');
define('EVENTS_FOLDER_ID', '0B1zQszUhxFKDRFJrUWc1V21ZZjg');