<?php

use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\PayPalHttpClient;


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
if (!isset($_GET['key'])) {
  failWithMsg('No event key given');
}
try {
  $config = PaymentConfigList::getConfig($_GET['key']);
} catch (Exception $e) {
  failWithMsg("Bad key: '$key'");
}

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
$logPath = realpath(__DIR__. '/'. $config->logFile);
$fh = fopen($logPath, 'a');
fclose($fh);

$rawLog = file_get_contents($logPath);
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

file_put_contents($config->logFile, json_encode($log, JSON_PRETTY_PRINT));

/***********************************************************************************
 * Paypal stuff
 **********************************************************************************/
$client = new PayPalHttpClient(
//  new ProductionEnvironment(
  new SandboxEnvironment(
    $config->paypalClientId,
    $config->paypalSecret
  ));
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
$spreadsheetId = $config->spreadSheetId;

try {
  RegistrationSaver::save(
    $sheetsService,
    $logger,
    $spreadsheetId,
    $paypalValidationResponse->result,
    $registrarDetails,
    $riderDetails,
    $config->competitions
  );
} catch (Google_Service_Exception $e) {
  failWithMsg($e->getMessage());
}
// All good!
success($paypalValidationResponse->result, $riderDetails);





