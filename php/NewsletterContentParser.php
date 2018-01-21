<?php
class NewsletterContentParser
{
	// TODO: add arguments to filter things
	public static function buildContentList(Google_Service_Drive $driveService, Google_Service_Sheets $sheetsService, Logger $logger, $spreadsheetId, $ogInfo)
	{
		$spreadsheetResponse = $sheetsService->spreadsheets->get($spreadsheetId);
		$sheet = $spreadsheetResponse->sheets[0];
            $sheetTitle = $sheet['properties']['title'];
      	$range = sprintf("'%s'!A2:H", $sheetTitle);
      	$sheetContentResponse = $sheetsService->spreadsheets_values->get($spreadsheetId, $range);
      	$rows = $sheetContentResponse->getValues();

      	$contentList = array();
      	foreach($rows as $index => $rowValues) {
      		// Insert index as React will need a key to work with.
      		array_unshift($rowValues, $index);

	      	// TODO: Only add things that match filters.
      		$contentList[] = new NewsletterContentEntry($rowValues, $ogInfo);
      	}
      	// TODO: set filters on object so it can be re-rendered.
      	return new NewsletterContentList($contentList);
	}
}