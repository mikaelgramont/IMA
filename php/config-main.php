<?php
define('SUBDOMAIN_KEY', 'main');

set_include_path(
  __DIR__.'/../php/:'.
  __DIR__.'/../php/'.SUBDOMAIN_KEY.'/:'.
  __DIR__.'/../php/results-html/:'.
  __DIR__.'/../php/vendor/tedivm/stash/src/'
);
require_once 'config-secrets.php';
require_once 'common-requires.php';

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

define('EVENT_REGISTRATION_HTML_PATH', './../pages/main/event-registrations/');
define('EVENT_REGISTRATION_SEPARATOR', 'SEPARATOR');

define('RESULTS_CACHE_PATH', 'results/');
define('RESULTS_HTML_PATH', './../pages/main/generated/results/');

// If modifying these scopes, delete your previously saved credentials
// at CREDENTIALS_PATH
define('SCOPES', implode(' ', array(
  Google_Service_Drive::DRIVE_METADATA_READONLY,
  Google_Service_Sheets::SPREADSHEETS
)));

/******************************************************************************
 * SITE CONTENT DEFINITION CONSTANTS
 *****************************************************************************/
define('BASE_URL', PageHelper::getBaseUrl());
define('FULL_URL', PageHelper::getFullUrl());
define('SITE_NAME', 'IMA - International Mountainboard Association');
define('KEYWORDS', 'IMA, international mountainboard association, mountainboard, dirtboard, allterrainboard, ATBA');
define('ANALYTICS_ID', 'UA-110037113-1');

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

/******************************************************************************
 * REGISTRATION
 *****************************************************************************/
define('REGISTRATION_USE_PRODUCTION', false);

if (REGISTRATION_USE_PRODUCTION) {
  define('PAYPAL_ACCOUNT_CDF_2019', PAYPAL_ACCOUNT_IMA);
  define('PAYPAL_CLIENT_ID_CDF_2019', PAYPAL_CLIENT_ID_IMA);
  define('PAYPAL_SECRET_CDF_2019', PAYPAL_SECRET_IMA);
} else {
  define('PAYPAL_ACCOUNT_CDF_2019', PAYPAL_ACCOUNT_SANDBOX);
  define('PAYPAL_CLIENT_ID_CDF_2019', PAYPAL_CLIENT_ID_SANDBOX);
  define('PAYPAL_SECRET_CDF_2019', PAYPAL_SECRET_SANDBOX);
}
