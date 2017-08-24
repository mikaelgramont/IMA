#!/usr/bin/env php
<?php
if (php_sapi_name() != 'cli') {
  throw new Exception('This application must be run on the command line.');
}
require_once __DIR__.'/../php/config.php';
require_once 'Helpers.php';
require_once 'Logger.php';
require_once 'Utils.php';

require_once 'EventParser.php';
require_once 'EventTemplateGenerator.php';

if (!file_exists(CREDENTIALS_PATH)) {
  throw new Exception("No token file at " . CREDENTIALS_PATH);
}
try {
  $accessToken = json_decode(file_get_contents(CREDENTIALS_PATH), true);
} catch (Exception $e) {
  throw new Exception("Could not decode the token at " . CREDENTIALS_PATH);
}

$logger = new Logger();

// Cache setup
$driver = new Stash\Driver\FileSystem(array('path' => CACHE_PATH));
$pool = new Stash\Pool($driver);
@$pool->clear();
$cacheId = EVENTS_CACHE_PATH;
$cacheItem = $pool->getItem($cacheId);

if ($cacheItem->isMiss()) {

	// Get the API client and construct the service object.
	$client = Helpers::getGoogleClientForWeb($accessToken);
	$driveService = new Google_Service_Drive($client);
	$sheetsService = new Google_Service_Sheets($client);

	$cacheItem->lock();
	try {
		$events = EventParser::buildEvents($driveService, $sheetsService, $logger, EVENTS_RESPONSE_SHEET_ID);
		$cacheItem->set($events);
		$cacheItem->expiresAfter(24 * 3600 * 2);
		$pool->save($cacheItem);
	} catch (Exception $e) {
		echo $logger->dumpText()."\n";
		die("There were errors");
	}
} else {
	$events = $cacheItem->get();
}

$out = "";
$generator = "";
foreach ($events as $event) {
	$generator = new EventTemplateGenerator($event, EVENTS_HTML_PATH);
	$generator->buildHTML($driveService);
	$eventOut = $generator->getFullOutput();
	$out .= $eventOut;
	echo $eventOut;
}

if ($generator) {
	$generator->saveToDisk($out);
}
$logger->log("All done.");
echo $logger->dumpText()."\n";