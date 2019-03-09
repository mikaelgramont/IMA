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
 * PAYPAL
 *****************************************************************************/
define('PAYPAL_ACCOUNT_SANDBOX', 'mgramont-seller-ima@gmail.com');
define('PAYPAL_CLIENT_ID_SANDBOX', 'AbFntL971D7Go7yCJl9hSdp1rzCZ3PYwYLhUv6hXbmcVneQw7vfu8aPS0ZA0bvarN0F21AD75St_lEJn');
define('PAYPAL_SECRET_SANDBOX', 'EOCMtIeYcbaHgkk1XRNIL6qXM8JWAN5xVRKVhORP0N4k9xGokBIHX9mI4dWSpmUlS7ZfB52FfAn9YRFK');
define('PAYPAL_SCRIPT_SANDBOX', 'https://www.paypal.com/sdk/js?currency=EUR&client-id=' . PAYPAL_CLIENT_ID_SANDBOX);


define('PAYPAL_ACCOUNT_PROD', '');
define('PAYPAL_CLIENT_ID_PROD', '');
define('PAYPAL_SECRET_PROD', '');

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
