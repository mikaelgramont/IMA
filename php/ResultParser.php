<?php
class ResultParser
{
	public static function buildResults(Google_Service_Drive $driveService, Google_Service_Sheets $sheetsService, Logger $logger, $folder)
	{
		$results = array();
		$logger->log("Scanning for result year folders...");

		// Each folder must contain results for a given year
		$folders = Helpers::getFileList($driveService, $folder, true /* Folders only */);
		foreach ($folders as $folder) {
		 	$year = $folder['name'];
			if (!is_numeric($year)) {
				$logger->log(sprintf("Skipping folder with non-numeric name '%s'", $year));
				continue;
			}
			$logger->log(sprintf("Scanning folder for year '%s'...", $year));
		  	$resultYear = new ResultYear($year);
		  	$locations = Helpers::getFileList($driveService, $folder["id"]);

		  	foreach ($locations as $file) {
		    	if (!Helpers::isSpreadsheet($file)) {
		      		$logger->log(sprintf("Skipping non-spreadsheet file '%s': '%s'", $file['name'], $file['mimeType']));
		      		continue;
		    	}
	      		$logger->log(sprintf(" - Reading spreadsheet file '%s'", $file['name']));
		    	$resultEntry = new ResultEntry($year, $file['name'], $file['description']);
		    	$spreadsheetResponse = $sheetsService->spreadsheets->get($file['id']);
		    
			    foreach ($spreadsheetResponse->sheets as $sheet) {
			    	$sheetTitle = $sheet['properties']['title'];
			      	$resultCategory = new ResultCategory($sheetTitle);
			      	$range = sprintf("'%s'!A2:F", $sheetTitle);
			      
			      	$sheetContentResponse = $sheetsService->spreadsheets_values->get($file['id'], $range);
			      	$values = $sheetContentResponse->getValues();
			      
			      	if (sizeof($values) == 0) {
			      		$logger->log(sprintf("   - Skipping empty sheet '%s'", $sheetTitle));
			      		continue;
			      	}
		      		$logger->log(sprintf("   - Reading sheet '%s'", $sheetTitle));
			      	foreach ($values as $index => $value) {
			        	$ranking = new ResultRanking(
			        	    $value[0],
                            $value[1],
                            isset($value[2]) ? $value[2] : 'NULL',
                            isset($value[3]) ? $value[3] : 'NULL',
                            isset($value[4]) ? $value[4] : 'NULL',
                            isset($value[5]) ? $value[5] : 'NULL'
                        );
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