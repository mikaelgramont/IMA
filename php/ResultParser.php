<?php
class ResultParser
{
	public static function buildResults(Google_Service_Drive $driveService, Google_Service_Sheets $sheetsService, Logger $logger, $folder)
	{
		$results = array();

		// Each folder must contain results for a given year
		$folders = Helpers::getFileList($driveService, $folder, true /* Folders only */);
		foreach ($folders as $folder) {
		  $year = $folder['name'];
		  if (!is_numeric($year)) {
		    $logger->log(sprintf("Found non-numeric folder with name '%s'", $year));
		    continue;
		  }

		  $resultYear = new ResultYear($year);
		  $locations = Helpers::getFileList($driveService, $folder["id"]);
		  foreach ($locations as $file) {
		    if (!Helpers::isSpreadsheet($file)) {
		      $logger->log(sprintf("Skipping non-spreadsheet file '%s': '%s'", $file['name'], $file['mimeType']));
		      continue;
		    }
		    $resultEntry = new ResultEntry($file['name']);
		    $spreadsheetResponse = $sheetsService->spreadsheets->get($file['id']);
		    
		    foreach ($spreadsheetResponse->sheets as $sheet) {
		      $sheetTitle = $sheet['properties']['title'];
		      $resultCategory = new ResultCategory($sheetTitle);
		      $range = sprintf("'%s'!A2:C", $sheetTitle);
		      
		      $sheetContentResponse = $sheetsService->spreadsheets_values->get($file['id'], $range);
		      $values = $sheetContentResponse->getValues();
		      
		      foreach ($values as $index => $value) {
		        $ranking = new ResultRanking($value[0], $value[1], isset($value[2]) ? $value[2] : 'NULL');
		        $resultCategory->addRanking($ranking);
		      }

		      $resultEntry->addCategory($resultCategory);
		    }

		    $resultYear->addEntry($resultEntry);
		  }

		  $results[] = $resultYear;
		}

		return $results;
	}
}