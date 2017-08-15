<?php
class EventParser
{
	public static function buildEvents(Google_Service_Drive $driveService, Google_Service_Sheets $sheetsService, Logger $logger, $sheetId)
	{
		$events = array();

		$range = sprintf("!A2:L");
		$sheetContentResponse = $sheetsService->spreadsheets_values->get($sheetId, $range);
		$rows = $sheetContentResponse->getValues();

		foreach ($rows as $index => $row) {
			// +2 because sheets start at 1, not 0, and the first row is header.
			$rowId = $index + 2;
			if (self::_isInThePast($row)) {
				$logger->log("Skipping past event on line $rowId");
				continue;
			}
			$errors = self::_validateEventValues($row);
			if (sizeof($errors) > 0) {
				$errorsAsString = implode(" // ", $errors);
				$logger->log("Skipping event on line $rowId because it has the following errors: {$errorsAsString}");
				continue;
			}

			$events[] = self::_buildEvent($row);

		}
		return $events;
	}

	private static function _isInThePast($row)
	{
		return false;		
	}

	private static function _validateEventValues($row)
	{
		return array();		
	}

	private static function _buildEvent($row)
	{
		$event = new EventEntry($row);
		return $event;		
	}
}