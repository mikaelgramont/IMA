<?php
set_include_path(
	__DIR__.'/../php/:'.
	__DIR__.'/../php/results-html/'.
	__DIR__.'/../php/vendor/tedivm/stash/src/'
);
require_once 'vendor/autoload.php';
require_once 'Head.php';
require_once 'Helpers.php';
require_once 'PageHelper.php';
require_once 'Pages.php';

define('DEBUG', true);

/******************************************************************************
 * GOOGLE DOCS PROCESSING CONSTANTS
 *****************************************************************************/
define('APPLICATION_NAME', 'IMA Website');
define('CREDENTIALS_PATH', __DIR__ . '/.credentials/credentials.json');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
define('CACHE_PATH', realpath(__DIR__ . '/../php/cache/'));
define('RESULTS_CACHE_PATH', 'results/');
define('EVENTS_CACHE_PATH', 'events/');

define('RESULTS_HTML_PATH', './../pages/generated/results/');
define('EVENTS_HTML_PATH', './../pages/generated/events/');

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
define('EVENTS_RESPONSE_SHEET_ID', '1EqMf72dGEAq-OtrNVTSTfFeRgne-JP5NtAZfBJ6C3i4');


/******************************************************************************
 * SITE CONTENT DEFINITION CONSTANTS
 *****************************************************************************/
define('BASE_URL', PageHelper::getBaseUrl());
define('SITE_NAME', 'IMA - International Mountainboard Association');
define('KEYWORDS', 'IMA, international mountainboard association, mountainboard, dirtboard, allterrainboard, ATBA');
