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
define('IMA_URL', 'https://www.mountainboardworld.org');
define('SITE_NAME', 'World Freestyle Championship - International Mountainboard Association');
define('KEYWORDS', 'IMA, international mountainboard association, mountainboard, freeestyle, dirtboard, allterrainboard, ATBA');
define('ANALYTICS_ID', 'UA-110037113-1');


/******************************************************************************
 * SOCIAL MEDIA CONSTANTS
 *****************************************************************************/
define('FB_EVENT_URL', 'https://www.facebook.com/events/988415618023625/');
define('YOUTUBE_URL', 'https://www.youtube.com/channel/UCXKsMfk4_H3CrDbJcpTbdgQ');
define('INSTAGRAM_URL', 'https://www.instagram.com/mountainboardinfopl');


/******************************************************************************
 * REGISTRATION CONSTANTS
 *****************************************************************************/
define('REGISTRATION_COST', 35);
define('REGISTRATION_DEADLINE', 'July 19th 2019');


/******************************************************************************
 * OPEN GRAPH
 *****************************************************************************/
define('OG_TITLE', 'World Freestyle Championship - International Mountainboard Association');
define('OG_DESCRIPTION', 'The official World Freestyle Championship registration and information.');
define('OG_URL', 'https://wfc.mountainboardworld.org/');
define('OG_SITE_NAME', 'World Freestyle Championship - International Mountainboard Association');
define('OG_IMAGE', 'https://wfc.mountainboardworld.org/images/logo.png');

/******************************************************************************
 * EMAIL
 *****************************************************************************/
define('EMAIL_IMA', 'mountainboardworld@gmail.com');
