<?php
class EventUpdates {
  // The name of the sheet
  public static $eventUpdateSheet = 'Updates';

  static function getConfig($eventKey) {
    $allEvents = [
      'WFC2019' => (object)[
        'name' => 'WFC 2019 - Poland',
        'offset' => 3,
        'spreadsheetId' => '15ImD2LEHH9C6Is2taoL7ZnDa6ZHnJAT2zZhqWxZsw6U',
        'cacheId' => 'live-updates-2019',
        'range' => 'A2:E',
      ],
    ];

    if (!isset($allEvents[$eventKey])) {
      return null;
    }

    return $allEvents[$eventKey];
  }

  public static function save($sheetsService, $spreadsheetId, $update) {
    $params = array("valueInputOption" => "RAW");
    $updateBody = new Google_Service_Sheets_ValueRange([
      'values' => [$update]
    ]);
    $sheetsService->spreadsheets_values->append($spreadsheetId, self::$eventUpdateSheet, $updateBody, $params);
  }
}