<?php
class SpreadsheetReader {
    public static function readRange($credentialsPath, $spreadsheetId, $range) {
        if (!file_exists($credentialsPath)) {
            throw new Exception("No token file");
        } else {
            try {
                $accessToken = json_decode(file_get_contents($credentialsPath), true);
            } catch (Exception $e) {
                throw new Exception("Could not decode the token");
            }
        }

        $client = Helpers::getGoogleClientForWeb($accessToken);
        $sheetsService = new Google_Service_Sheets($client);
        $sheetContentResponse = $sheetsService->spreadsheets_values->get($spreadsheetId, $range);
        $values = $sheetContentResponse->getValues();
        return $values;
    }
}