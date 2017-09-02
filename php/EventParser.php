<?php
class EventParser
{
	public static function buildEvents(Google_Service_Drive $driveService, Google_Service_Sheets $sheetsService, Logger $logger, $sheetId)
	{
		$events = array();

		$range = sprintf("!A2:M");
		$sheetContentResponse = $sheetsService->spreadsheets_values->get($sheetId, $range);
		$rows = $sheetContentResponse->getValues();
		$hasErrors = false;

		$logger->log("Reading events listed in the spreadsheet...");

		foreach ($rows as $index => $row) {
			// +2 because sheets start at 1, not 0, and the first row is header.
			$rowId = $index + 2;
			$logMsg = "- reading event on row $rowId:";
			$event = self::_buildEvent($row);
			if (self::_isInThePast($event)) {
				$logger->log($logMsg .  " skipping because it's in the past.");
				continue;
			}
			$errors = self::_validateEvent($event);
			if (sizeof($errors) > 0) {
				$hasErrors = true;
				$errorsAsString = implode(" // ", $errors);
				$logger->log($logMsg .  "skipping because it has the following errors: {$errorsAsString}.");
				continue;
			}
			$logger->log($logMsg. " ok.");

			 $timestamp = $event->getFirstDayTimeStamp();
			 $events[$timestamp] = $event;
		}

		if ($hasErrors) {
			throw new Exception("Error processing events", 1);
		}
		// Newest event first.
		krsort($events);
		return $events;
	}

	private static function _isInThePast(EventEntry $event)
	{
		$todayTimestamp = mktime(0, 0, 0);
		$twoDaysPrior = $todayTimestamp - 24 * 3600;
		if ($event->getFirstDayTimeStamp() > $twoDaysPrior) {
			return false;
		}
		if ($event->getLastDayTimeStamp() > $twoDaysPrior) {
			return false;
		}
		return true;
	}

	private static function _validateEvent(EventEntry $event)
	{
		$errors = array();
		if ($event->getLastDayTimeStamp() && $event->getFirstDayTimeStamp() > $event->getLastDayTimeStamp()) {
			$errors[] = "First day date is after last day date";
		}
		return $errors;	
	}

	private static function _buildEvent($row)
	{
		$event = new EventEntry($row);
		return $event;		
	}
}