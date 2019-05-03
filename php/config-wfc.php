<?php
define('SUBDOMAIN_KEY', 'wfc');

set_include_path(
  __DIR__.'/../php/:'.
  __DIR__.'/../php/'.SUBDOMAIN_KEY.'/:'.
  __DIR__.'/../php/results-html/:'.
  __DIR__.'/../php/vendor/tedivm/stash/src/'
);
require_once 'config-secrets.php';
require_once 'common-requires.php';

/******************************************************************************
 * SITE CONTENT DEFINITION CONSTANTS
 *****************************************************************************/
define('BASE_URL', PageHelper::getBaseUrl());
define('FULL_URL', PageHelper::getFullUrl());
define('IMA_URL', 'https://www.mountainboardworld.org');
define('SITE_NAME', 'World Freestyle Championship - International Mountainboard Association');
define('KEYWORDS', 'IMA, international mountainboard association, mountainboard, freeestyle, dirtboard, allterrainboard, ATBA');
define('ANALYTICS_ID', 'UA-110037113-2');


/******************************************************************************
 * SOCIAL MEDIA CONSTANTS
 *****************************************************************************/
define('FB_EVENT_URL', 'https://www.facebook.com/events/988415618023625/');
define('YOUTUBE_URL', 'https://www.youtube.com/channel/UCXKsMfk4_H3CrDbJcpTbdgQ');
define('INSTAGRAM_URL', 'https://www.instagram.com/mountainboardinfopl');


/******************************************************************************
 * OPEN GRAPH
 *****************************************************************************/
define('OG_TITLE', 'World Freestyle Championship - International Mountainboard Association');
define('OG_DESCRIPTION', 'The official World Freestyle Championship registration and information.');
define('OG_URL', 'https://wfc.mountainboardworld.org/');
define('OG_SITE_NAME', 'World Freestyle Championship - International Mountainboard Association');
define('OG_IMAGE', 'https://wfc.mountainboardworld.org/images/poster.jpg');

/******************************************************************************
 * EMAIL
 *****************************************************************************/
define('EMAIL_IMA', 'mountainboardworld@gmail.com');

/******************************************************************************
 * GOOGLE DOCS PROCESSING CONSTANTS
 *****************************************************************************/
define('APPLICATION_NAME', 'IMA Website');
define('CREDENTIALS_PATH', __DIR__ . '/.credentials/credentials.json');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');

// If modifying these scopes, delete your previously saved credentials
// at CREDENTIALS_PATH
define('SCOPES', implode(' ', array(
  Google_Service_Drive::DRIVE_METADATA_READONLY,
  Google_Service_Sheets::SPREADSHEETS
)));

/******************************************************************************
 * REGISTRATION
 *****************************************************************************/
define('REGISTRATION_USE_PRODUCTION', false);

if (REGISTRATION_USE_PRODUCTION) {
  define('PAYPAL_ACCOUNT', PAYPAL_ACCOUNT_IMA);
  define('PAYPAL_CLIENT_ID', PAYPAL_CLIENT_ID_IMA);
  define('PAYPAL_SECRET', PAYPAL_SECRET_IMA);
} else {
  define('PAYPAL_ACCOUNT', PAYPAL_ACCOUNT_SANDBOX);
  define('PAYPAL_CLIENT_ID', PAYPAL_CLIENT_ID_SANDBOX);
  define('PAYPAL_SECRET', PAYPAL_SECRET_SANDBOX);
}

define('PAYPAL_SCRIPT', 'https://www.paypal.com/sdk/js?currency=EUR&client-id=' . PAYPAL_CLIENT_ID);

/******************************************************************************
 * WFC REGISTRATION CONSTANTS
 *****************************************************************************/
define('REGISTRATION_COST', 35);
define('REGISTRATION_DEADLINE', 'July 19th 2019');
define('REGISTRATIONS_LOG_FILE', '../logs/wfc-registrations.json');

