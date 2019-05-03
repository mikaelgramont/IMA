<?php

class RegistrationSaver
{
  const YES = 'Yes';
  const NO = 'No';

  public static function save(
    $sheetsService, $logger, $spreadsheetId, $paymentDetails, $registrarDetails, $riderDetails, $competitions, $additionalTextFields)
  {
    $logger->log("Adding payment to Google Sheet.\n");

    list($riderValues, $paymentValues) = self::_getSpreadSheetValues($paymentDetails, $registrarDetails, $riderDetails, $competitions, $additionalTextFields);

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

  private static function _getSpreadSheetValues($paypal, $registrar, $riders, $competitions, $additionalTextFields)
  {
    $date = date('Y-m-d H:i:s');

    if ($paypal) {
      $orderId = $paypal->id;
      $paymentDate = $paypal->create_time;
      $paymentAmount = $paypal->purchase_units[0]->amount->value;
      $paymentCurrency = $paypal->purchase_units[0]->amount->currency_code;
      $paymentName = $paypal->payer->name->given_name . ' ' . $paypal->payer->name->surname;
      $paymentEmail = $paypal->payer->email_address;
    } else {
      $orderId = Google_Model::NULL_VALUE;
      $paymentDate = Google_Model::NULL_VALUE;
      $paymentAmount = Google_Model::NULL_VALUE;
      $paymentCurrency = Google_Model::NULL_VALUE;
      $paymentName = Google_Model::NULL_VALUE;
      $paymentEmail = Google_Model::NULL_VALUE;
    }

    $riderValues = array();
    foreach ($riders as $rider) {
      $thisRiderValues = array(
        $date,
        $orderId,
        isset($rider['number']) && $rider['number'] ? $rider['number'] : Google_Model::NULL_VALUE,
        $rider['firstName'],
        $rider['lastName'],
        $rider['country'] ? $rider['country'] :  Google_Model::NULL_VALUE,
        $rider['category'] ? $rider['category'] :  Google_Model::NULL_VALUE,
      );
      foreach ($competitions as $competitionName) {
        if (isset($rider[$competitionName])) {
          $thisRiderValues[] = self::YES;
        } else {
          $thisRiderValues[] = self::NO;
        }
      }
      foreach ($additionalTextFields as $additionalTextField) {
        $thisRiderValues[] = isset($rider[$additionalTextField]) ? $rider[$additionalTextField] : Google_Model::NULL_VALUE;
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