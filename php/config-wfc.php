<?php
set_include_path(
  __DIR__.'/../php/:'.
  __DIR__.'/../php/wfc/:'.
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
define('SUBDOMAIN_KEY', 'wfc');






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
define('FB_EVENT_URL', '');


/******************************************************************************
 * INSTAGRAM CONSTANTS
 *****************************************************************************/
define('INSTAGRAM_USERNAME', 'imountainboard');
define('IG_ACCESS_TOKEN', '8fd5c2fbfee5446cba3a2bb04f7270cb');


/******************************************************************************
 * OPEN GRAPH
 *****************************************************************************/
define('OG_TITLE', 'International Mountainboard Association');
define('OG_DESCRIPTION', 'The official International Mountainboard Association site.');
define('OG_URL', 'https://www.mountainboardworld.org/');
define('OG_SITE_NAME', 'International Mountainboard Association');
define('OG_IMAGE', 'https://www.mountainboardworld.org/images/logo.png');

/******************************************************************************
 * EMAIL
 *****************************************************************************/
define('EMAIL_IMA', 'mountainboardworld@gmail.com');
