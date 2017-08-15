#!/usr/bin/env php
<?php
require_once __DIR__.'/../php/config.php';
require_once 'Helpers.php';
require_once 'Logger.php';

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

// Cache setup
$driver = new Stash\Driver\FileSystem(array('path' => CACHE_PATH));
$pool = new Stash\Pool($driver);
$cacheId = RESULTS_CACHE_PATH;
$cacheItem = $pool->getItem($cacheId);

// Get the API client and construct the service object.
$client = Helpers::getGoogleClientForWeb($accessToken);
$driveService = new Google_Service_Drive($client);
$sheetsService = new Google_Service_Sheets($client);

$results = ResultParser::buildResults($driveService, $sheetsService, $logger, RESULTS_FOLDER_ID);
echo "Parsed results\n";

$cacheItem->set($results);
$cacheItem->lock();
$pool->save($cacheItem);
echo "Cached results\n";

foreach ($results as $result) {
	$generator = new ResultTemplateGenerator($result, RESULTS_HTML_PATH);
	$generator->run();
}

echo "Saved HTML\n";


echo "Done\n";
