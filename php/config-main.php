<?php
set_include_path(
	__DIR__.'/../php/:'.
	__DIR__.'/../php/main/:'.
	__DIR__.'/../php/results-html/:'.
	__DIR__.'/../php/vendor/tedivm/stash/src/'
);
require_once 'vendor/autoload.php';
require_once 'Auth.php';
require_once 'Cache.php';
require_once 'EventEntry.php';
require_once 'Footer.php';
require_once 'Head.php';
require_once 'Header.php';
require_once 'Helpers.php';
require_once 'Instagram.php';
require_once 'InstagramTag.php';
require_once 'Logger.php';
require_once 'NewsPage.php';
require_once 'PageHelper.php';
require_once 'Pages.php';
require_once 'Utils.php';

define('DEBUG', false);

define('SUBDOMAIN_KEY', 'main');

/******************************************************************************
 * GOOGLE DOCS PROCESSING CONSTANTS
 *****************************************************************************/
define('APPLICATION_NAME', 'IMA Website');
define('CREDENTIALS_PATH', __DIR__ . '/.credentials/credentials.json');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
define('CACHE_PATH', realpath(__DIR__ . '/../php/cache'));

define('ARTICLES_HTML_PATH', './../pages/main/articles/');
define('ARTICLES_SEPARATOR', 'SEPARATOR');

define('EVENTS_CACHE_PATH', 'events/');
define('EVENTS_HTML_PATH', './../pages/main/generated/events/');

define('INTERVIEWS_HTML_PATH', './../pages/main/interviews/');
define('INTERVIEWS_SEPARATOR', 'SEPARATOR');

define('NEWS_HTML_PATH', './../pages/main/news/');
define('NEWS_SEPARATOR', 'SEPARATOR');
define('NEWS_COUNT', 4);

define('RESULTS_CACHE_PATH', 'results/');
define('RESULTS_HTML_PATH', './../pages/main/generated/results/');

// If modifying these scopes, delete your previously saved credentials
// at CREDENTIALS_PATH
define('SCOPES', implode(' ', array(
  Google_Service_Drive::DRIVE_METADATA_READONLY,
  Google_Service_Sheets::SPREADSHEETS
 )));

// The ID of the folder containing public documents.
define('PUBLIC_DOCUMENTS_FOLDER_ID', '0B1zQszUhxFKDVlV6TWZ3UldYRmM');
define('RESULTS_FOLDER_ID', '0B1zQszUhxFKDbjVvSjJQQ05IbkU');
define('RESULTS_SUBMISSION_DOC_URL', 'https://docs.google.com/document/d/102fDsTnnquc4gFUVWaOTMYdhjOO8LJW6dWQzbVRjZm8/edit');

define('EVENTS_FOLDER_ID', '0B1zQszUhxFKDRFJrUWc1V21ZZjg');
define('EVENTS_RESPONSE_SHEET_ID', '1EqMf72dGEAq-OtrNVTSTfFeRgne-JP5NtAZfBJ6C3i4');
define('EVENT_SUBMISSION_FORM_URL', 'https://docs.google.com/forms/d/16Gj0psKKPtSAoP0c2wOOoegr4Uvka2WuIXo6RFMXGrQ');

define('NEWSLETTER_CONTENT_SPREADSHEET_ID', '1Ic2rtD0-OtrIwOI_Zq6mnARc-Iczqkolks-giA51ztc');

/******************************************************************************
 * SITE CONTENT DEFINITION CONSTANTS
 *****************************************************************************/
define('BASE_URL', PageHelper::getBaseUrl());
define('FULL_URL', PageHelper::getFullUrl());
define('SITE_NAME', 'IMA - International Mountainboard Association');
define('KEYWORDS', 'IMA, international mountainboard association, mountainboard, dirtboard, allterrainboard, ATBA');
define('ANALYTICS_ID', 'UA-110037113-1');


/******************************************************************************
 * FACEBOOK CONSTANTS
 *****************************************************************************/
define('FB_APP_ID', '186575118694854');
define('FB_APP_SECRET', '17a2997a4ed3af6041a0020d8d15294a');


/******************************************************************************
 * INSTAGRAM CONSTANTS
 *****************************************************************************/
define('INSTAGRAM_USERNAME', 'imountainboard');
define('IG_ACCESS_TOKEN', '8fd5c2fbfee5446cba3a2bb04f7270cb');


/******************************************************************************
 * TWITTER CONSTANTS
 *****************************************************************************/
define('TWITTER_API_KEY', 'jhpYg8UNfQIefR2oNpcskNKpc');
define('TWITTER_API_SECRET', 'gAGSry963qfy30pdayHPxc1BnCTtbb73ziH4zZqtT6yQfVnly4');
define('TWITTER_ACCESS_TOKEN', '74682934-qzS7nZ2ROxFYscp7eV6rx98PxOYdzTPcajY6zTeyy');
define('TWITTER_ACCESS_TOKEN_SECRET', '9yWuJQrP5bzc5BS2MwgNOQn7ds4Cs6mdt2QUqjPDC4yQr');
define('TWITTER_OWNER', 'mikaelgramont');
define('TWITTER_OWNER_ID', '74682934');


/******************************************************************************
 * OPEN GRAPH
 *****************************************************************************/
define('OG_TITLE', 'International Mountainboard Association');
define('OG_DESCRIPTION', 'The official International Mountainboard Association site.');
define('OG_URL', 'https://www.mountainboardworld.org/');
define('OG_SITE_NAME', 'International Mountainboard Association');
define('OG_IMAGE', 'https://www.mountainboardworld.org/images/logo.png');

/******************************************************************************
 * NEWSLETTER
 *****************************************************************************/
define('OGINFO_PATH', CACHE_PATH . '/OGInfo.json');
define('NEWSLETTER_CONTENT_CACHE_PATH', 'newsletter/');
define('FIRST_NEWSLETTER_MONTH', 'Feb 2017');

/******************************************************************************
 * AUTH
 *****************************************************************************/
define('PWFILE', '../php/pw.json');

/******************************************************************************
 * EMAIL
 *****************************************************************************/
define('EMAIL_IMA', 'mountainboardworld@gmail.com');
define('EMAIL_INTERNATIONAL_COORDINATION', 'flavio.nottalgiovanni@gmail.com');