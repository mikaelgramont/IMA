#!/usr/bin/env php
<?php
if (php_sapi_name() != 'cli') {
  throw new Exception('This application must be run on the command line.');
}
require_once __DIR__ . '/../php/config-main.php';
require_once 'Cache.php';
require_once 'Helpers.php';
require_once 'Logger.php';
require_once 'Utils.php';

require_once 'ResultCategory.php';
require_once 'ResultEntry.php';
require_once 'ResultParser.php';
require_once 'ResultRanking.php';
require_once 'ResultTemplateGenerator.php';
require_once 'ResultYear.php';

if (!file_exists(CREDENTIALS_PATH)) {
  throw new Exception("No token file at " . CREDENTIALS_PATH);
}
try {
  $accessToken = json_decode(file_get_contents(CREDENTIALS_PATH), true);
} catch (Exception $e) {
  throw new Exception("Could not decode the token at " . CREDENTIALS_PATH);
}

$logger = new Logger();

$pool = Cache::getPool();
$pool->clear();
$cacheId = RESULTS_CACHE_PATH;
$cacheItem = $pool->getItem($cacheId);

if ($cacheItem->isMiss()) {

	// Get the API client and construct the service object.
	$client = Helpers::getGoogleClientForWeb($accessToken);
	$driveService = new Google_Service_Drive($client);
	$sheetsService = new Google_Service_Sheets($client);

	$cacheItem->lock();
	$results = ResultParser::buildResults($driveService, $sheetsService, $logger, RESULTS_FOLDER_ID);
	$cacheItem->set($results);
	$cacheItem->expiresAfter(24 * 3600 * 2);
	$pool->save($cacheItem);
} else {
	$results = $cacheItem->get();
}

foreach ($results as $result) {
	$generator = new ResultTemplateGenerator($result, RESULTS_HTML_PATH, $logger);
	$generator->buildHTML();
	//echo $generator->getFullOutput();
	$generator->saveToDisk();
}
