<?php
set_time_limit(60);
$isError = false;

if (!in_array($_REQUEST['type'], array('events', 'results'))) {
	$isError = true;
	$errorMessage = "Unrecognized type";
}

if (!file_exists(CREDENTIALS_PATH)) {
	$isError = true;
	$errorMessage = "No token file";
} else {
	try {
	  $accessToken = json_decode(file_get_contents(CREDENTIALS_PATH), true);
	} catch (Exception $e) {
		$isError = true;
		$errorMessage = "Could not decode the token";
	}
}

if (!$isError) {
	// Get the API client and construct the service object.
	$client = Helpers::getGoogleClientForWeb($accessToken);
	$driveService = new Google_Service_Drive($client);
	$sheetsService = new Google_Service_Sheets($client);
	$logger = new Logger();
	$pool = Cache::getPool();

	switch ($_REQUEST['type']) {
		case 'results':
			require_once 'ResultCategory.php';
			require_once 'ResultEntry.php';
			require_once 'ResultParser.php';
			require_once 'ResultRanking.php';
			require_once 'ResultTemplateGenerator.php';
			require_once 'ResultYear.php';
			try {
				$results = ResultParser::buildResults($driveService, $sheetsService, $logger, RESULTS_FOLDER_ID);
				foreach ($results as $result) {
					$generator = new ResultTemplateGenerator($result, RESULTS_HTML_PATH);
					$generator->buildHTML();
					$generator->saveToDisk();
				}
			} catch (Exception $e) {
				$isError = true;
				$errorMessage = "Could not update results. Please contact the admin.";
			}
			$redirectUrl = BASE_URL . 'done-updating?type=results';
			break;

		case 'events':
			require_once 'EventParser.php';
			require_once 'EventTemplateGenerator.php';
			try {
				$cacheId = EVENTS_CACHE_PATH;
				$cacheItem = $pool->getItem($cacheId);
				$events = EventParser::buildEvents($driveService, $sheetsService, $logger, EVENTS_RESPONSE_SHEET_ID);
				$cacheItem->lock();
				$cacheItem->set($events);
				$cacheItem->expiresAfter(24 * 3600 * 2);
				$pool->save($cacheItem);				
				$out = "";
				$generator = "";
				foreach ($events as $event) {
					$generator = new EventTemplateGenerator($event, EVENTS_HTML_PATH);
					$generator->buildHTML($driveService);
					$eventOut = $generator->getFullOutput();
					$out .= $eventOut;
				}

				if ($generator) {
					$generator->saveToDisk($out);
				}
			} catch (Exception $e) {
				$isError = true;
				$errorMessage = "Could not update events. Please contact the admin.";
			}
			$redirectUrl = BASE_URL . 'done-updating?type=events';
			break;
	}
}

if ($isError) {
	$redirectUrl = BASE_URL . 'done-updating?error='.urlencode($errorMessage);
}
header("Location: " . $redirectUrl);
exit();

