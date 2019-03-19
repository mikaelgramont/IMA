<?php

use PayPalCheckoutSdk\Orders\OrdersGetRequest;

function failWithMsg($msg)
{
  $output = new stdClass();
  $output->status = 'NOK';
  $output->error = $msg;
  echo json_encode($output);
  exit();
}

function success()
{
  $output = new stdClass();
  $output->status = 'OK';
  echo json_encode($output);
  exit();
}

require_once('RegistrationSaver.php');

header('Content-Type: application/json');

/***********************************************************************************
 * Request stuff
 **********************************************************************************/
$_POST = json_decode(file_get_contents('php://input'), true);
$orderId = isset($_POST['orderID']) ? $_POST['orderID'] : null;
if (!$orderId) {
  // Payment doesn't seem to have worked
  failWithMsg('No order id given');
}
$registrarDetails = isset($_POST['registrarDetails']) ? $_POST['registrarDetails'] : null;
if (!$registrarDetails) {
  failWithMsg('No registrar details given');
}
$riderDetails = isset($_POST['riderDetails']) ? $_POST['riderDetails'] : null;
if (!$riderDetails) {
  failWithMsg('No rider details given');
}

// Necessary?
$orderDetails = isset($_POST['orderDetails']) ? $_POST['orderDetails'] : null;

/***********************************************************************************
 * Paypal stuff
 **********************************************************************************/
$client = PayPalClient::client();
$paypalValidationResponse = $client->execute(new OrdersGetRequest($orderId));
if ($paypalValidationResponse->result->status !== 'COMPLETED') {
  // Payment doesn't seem to have worked
  failWithMsg('Payment not found');
}

/***********************************************************************************
 * Spreadsheet stuff
 **********************************************************************************/
$errorMessage = "";
if (!file_exists(CREDENTIALS_PATH)) {
  $errorMessage = "No token file";
} else {
  try {
    $accessToken = json_decode(file_get_contents(CREDENTIALS_PATH), true);
  } catch (Exception $e) {
    $errorMessage = "Could not decode the token";
  }
}
if ($errorMessage) {
  failWithMsg($errorMessage);
}

$client = Helpers::getGoogleClientForWeb($accessToken);
$sheetsService = new Google_Service_Sheets($client);
$logger = new Logger();
$spreadsheetId = REGISTRATIONS_SPREADSHEET_ID;

// TODO: append raw data to a json file

try {
  RegistrationSaver::save(
    $sheetsService,
    $logger,
    $spreadsheetId,
    $paypalValidationResponse->result,
    $registrarDetails,
    $riderDetails
  );
} catch (Google_Service_Exception $e) {
  failWithMsg($e->getMessage());
}

// TODO: send an email?

// All good!
success();





