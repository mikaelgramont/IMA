<?php
class NewsletterContentUpdater
{
	public static function updateEntry($sheetsService, $logger, $spreadsheetId, $id, $discarded, $markAsUsed)
	{
		$logger->log("Updating row in Google Sheets.\n");

		$data = array();
	    $data[] = new Google_Service_Sheets_ValueRange(
	        array(
	        	'range' => sprintf("%s%s", NewsletterContentEntry::$discardedColumn, $id),
	        	'values' => array(array($discarded ? "y" : ""))
	        )
	    );
	    $data[] = new Google_Service_Sheets_ValueRange(
	        array(
	        	'range' => sprintf("%s%s", NewsletterContentEntry::$markAsUsedColumn, $id),
	        	'values' => array(array($markAsUsed ? "y" : ""))
	        )
	    );
		$requestBody = new Google_Service_Sheets_BatchUpdateValuesRequest(array(
		  'valueInputOption' => "USER_ENTERED",
		  'data' => $data
		));
		$spreadsheetResponse = $sheetsService->spreadsheets_values->batchUpdate($spreadsheetId, $requestBody);

		// $logger->log(var_export($spreadsheetResponse, true));
		// error_log($logger->dumpText());
	}
}