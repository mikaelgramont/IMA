<?php
require_once 'NewsletterContentEntry.php';
require_once 'NewsletterContentList.php';
require_once 'NewsletterContentParser.php';
require_once 'NewsletterContentUpdater.php';
require_once 'OGInfoCache.php';

$errorMessage = "";
if (!file_exists(CREDENTIALS_PATH)) {
	$errorMessage = "No token file";
} else {
	try {
	  $accessToken = json_decode(file_get_contents(CREDENTIALS_PATH), true);
	} catch (Exception $e) {
		$errorMessage = "Could not decode the token";
	}
}

if ($errorMessage) {
	$obj = new stdClass();
	$obj->error = $errorMessage;
	$json = json_encode($obj);
	echo $json();
	exit();
}

$client = Helpers::getGoogleClientForWeb($accessToken);
$sheetsService = new Google_Service_Sheets($client);
$logger = new Logger();
$spreadsheetId = NEWSLETTER_CONTENT_SPREADSHEET_ID;

// Validate input
if (!isset($_POST['id']) || !isset($_POST['discarded']) || !isset($_POST['markAsUsed'])  || !isset($_POST['currentTime']) ) {
	$obj = new stdClass();
	$obj->error = "Inputs not set properly";
	$json = json_encode($obj);
	echo $json();
	exit();	
}

$id = (integer) $_POST['id'];
$discarded = $_POST['discarded'] == "true" ? true : false;
$markAsUsed = $_POST['markAsUsed'] == "true" ? true : false;
$currentTime = $_POST['currentTime'];

// Update the spreadsheet
try {
	NewsletterContentUpdater::updateEntry($sheetsService, $logger, $spreadsheetId, $id, $discarded, $markAsUsed);
} catch (Google_Service_Exception $e) {
	$obj = new stdClass();
	$obj->errorMessage = $e->getMessage();
	$json = json_encode($obj);
	echo $json();
	exit();
}

// Bust cache
$pool = Cache::getPool();
$cacheItem = $pool->getItem(NEWSLETTER_CONTENT_CACHE_PATH);
$cacheItem->clear();

// Rebuild the whole list
$ogInfo = OGInfoCache::getInstance(OGINFO_PATH);
$contentList = NewsletterContentParser::buildContentList($sheetsService, $logger, $spreadsheetId, $ogInfo, $currentTime, true, true);

// Send only the appropriate one.
$row = null;
$ids = array();
foreach ($contentList->content as $currentRow) {
	$ids[] = $currentRow->metadata->id;
	if ($currentRow->metadata->id == $id) {
		$row = $currentRow;
	}
}

if (!$row) {
	$obj = new stdClass();
	$errorMessage = "Could not find row with id: ". $id . "\n";
	$obj->errorMessage = $errorMessage;
	$json = json_encode($obj);
	echo $json;
	exit();
}

$obj = new stdClass();
$obj->row = $row;
$obj->log = $logger->dumpText();
$json = json_encode($obj);
echo $json;