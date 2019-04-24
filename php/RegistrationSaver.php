<?php

class RegistrationSaver
{
  const YES = 'Yes';
  const NO = 'No';

  public static function save(
    $sheetsService, $logger, $spreadsheetId, $paypalValidationResponse, $registrarDetails, $riderDetails, $competitions)
  {
    $logger->log("Adding payment to Google Sheet.\n");

    list($riderValues, $paymentValues) = self::_getSpreadSheetValues($paypalValidationResponse, $registrarDetails, $riderDetails, $competitions);

    $params = array("valueInputOption" => "RAW");
    $riderRequestBody = new Google_Service_Sheets_ValueRange([
      'values' => $riderValues
    ]);
    $spreadsheetResponse = $sheetsService->spreadsheets_values->append($spreadsheetId, REGISTRATIONS_SPREADSHEET_RIDER_SHEET, $riderRequestBody, $params);
    $logger->log(sprintf("%d cells appended for rider values.", $spreadsheetResponse->getUpdates()->getUpdatedCells()));
    $logger->log(var_export($spreadsheetResponse, true));

    $paymentRequestBody = new Google_Service_Sheets_ValueRange([
      'values' => $paymentValues
    ]);
    $spreadsheetResponse = $sheetsService->spreadsheets_values->append($spreadsheetId, REGISTRATIONS_SPREADSHEET_PAYMENT_SHEET, $paymentRequestBody, $params);
    $logger->log(sprintf("%d cells appended for payment values.", $spreadsheetResponse->getUpdates()->getUpdatedCells()));
    $logger->log(var_export($spreadsheetResponse, true));
    error_log($logger->dumpText());
  }

  private static function _getSpreadSheetValues($paypal, $registrar, $riders, $competitions)
  {
    $date = date('Y-m-d H:i:s');

    $orderId = $paypal->id;
    $paymentDate = $paypal->create_time;
    $paymentAmount = $paypal->purchase_units[0]->amount->value;
    $paymentCurrency = $paypal->purchase_units[0]->amount->currency_code;
    $paymentName = $paypal->payer->name->given_name . ' ' . $paypal->payer->name->surname;
    $paymentEmail = $paypal->payer->email_address;

    $riderValues = array();
    foreach ($riders as $rider) {
      $thisRiderValues = array(
        $date,
        $orderId,
        isset($rider['number']) ? $rider['number'] : '',
        $rider['firstName'],
        $rider['lastName'],
        $rider['country'],
        $rider['category'],
      );
      foreach ($competitions as $competitionName) {
        if (isset($rider[$competitionName])) {
          $thisRiderValues[] = self::YES;
        } else {
          $thisRiderValues[] = self::NO;
        }
      }

      $riderValues[] = $thisRiderValues;
    }
    $paymentValues = array(
      array(
        $date,
        $orderId,
        $paymentName,
        $paymentEmail,
        $paymentDate,
        $paymentAmount,
        $paymentCurrency,
        sizeof($riders),
        $registrar['firstName'],
        $registrar['lastName'],
        $registrar['email']
      )
    );

    return array($riderValues, $paymentValues);
  }
}