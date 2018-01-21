<?php
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
	} else {

		require_once 'NewsletterContentEntry.php';
		require_once 'NewsletterContentList.php';
		require_once 'NewsletterContentParser.php';
		require_once 'OGInfoCache.php';

		// Get the API client and construct the service object.
		$client = Helpers::getGoogleClientForWeb($accessToken);
		$driveService = new Google_Service_Drive($client);
		$sheetsService = new Google_Service_Sheets($client);
		$logger = new Logger();
		$spreadsheetId = NEWSLETTER_CONTENT_SPREADSHEET_ID;
		
		$ogInfo = OGInfoCache::getInstance(OGINFO_PATH);

		$startMonth = isset($_POST['currentIssueTime']) ? date('Y-M', $_POST['currentIssueTime']) : FIRST_NEWSLETTER_MONTH;
		
		$showUsed = false;
		if (isset($_POST['showUsed'])) {
			$showUsed =	$_POST['showUsed'] == "true" ? true : false;
		}

		$showDiscarded = false;
		if (isset($_POST['showDiscarded'])) {
			$showDiscarded = $_POST['showDiscarded'] == "true" ? true : false;
		}

		$contentList = NewsletterContentParser::buildContentList($driveService, $sheetsService, $logger, $spreadsheetId, $ogInfo, $startMonth, $showUsed, $showDiscarded);
		if ($ogInfo->isDirty()) {
			$ogInfo->writeToDisk();
		}
		
		$obj = new stdClass();
		$obj->content = $contentList->content;
		$obj->startMonth = $startMonth;
		$obj->showUsed = $showUsed;
		$obj->showDiscarded = $showDiscarded;

	}
	echo json_encode($obj);
?>
