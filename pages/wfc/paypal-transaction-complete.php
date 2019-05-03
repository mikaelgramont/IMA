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

function success($paypal, $riders)
{
  $output = new stdClass();
  $output->status = 'OK';

  $paymentData = new stdClass();
  $paymentData->id = $paypal->id;
  $paymentData->amount = $paypal->purchase_units[0]->amount;
  $output->paymentData = $paymentData;
  $output->riders = $riders;
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
 * Log all request data before processing
 **********************************************************************************/
$rawLog = file_get_contents(REGISTRATIONS_LOG_FILE);
if (!$rawLog) {
  $log = [];
} else {
  $log = json_decode($rawLog);
}

$entry = new stdClass();
$entry->date = date('Y-m-d H:i:s');;
$entry->orderId = $orderId;
$entry->registrarDetails = $registrarDetails;
$entry->riderDetails = $riderDetails;
$entry->orderDetails = $orderDetails;
$log[] = $entry;

file_put_contents(REGISTRATIONS_LOG_FILE, json_encode($log, JSON_PRETTY_PRINT));

/***********************************************************************************
 * Paypal stuff
 **********************************************************************************/
if (REGISTRATION_USE_PRODUCTION) {
  $client = new PayPalHttpClient(new ProductionEnvironment(PAYPAL_CLIENT_ID, PAYPAL_SECRET));
} else {
  $client = new PayPalHttpClient(new SandboxEnvironment(PAYPAL_CLIENT_ID, PAYPAL_SECRET));
}

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
$spreadsheetId = WFC_REGISTRATIONS_SPREADSHEET_ID;

try {
  RegistrationSaver::save(
    $sheetsService,
    $logger,
    $spreadsheetId,
    $paypalValidationResponse->result,
    $registrarDetails,
    $riderDetails,
    array(PaymentConfigList::SLALOM, PaymentConfigList::FREESTYLE)
  );
} catch (Google_Service_Exception $e) {
  failWithMsg($e->getMessage());
}
// All good!
success($paypalValidationResponse->result, $riderDetails);





