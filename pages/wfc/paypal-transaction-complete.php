<?php
use PayPalCheckoutSdk\Orders\OrdersGetRequest;

header('Content-Type: application/json');

$_POST = json_decode(file_get_contents('php://input'), true);

//error_log(var_export($_POST, true));

$orderId = isset($_POST['orderID']) ? $_POST['orderID'] : null;
$client = PayPalClient::client();
$response = $client->execute(new OrdersGetRequest($orderId));

$output = new stdClass();
if ($response->result->status === 'COMPLETED') {
  $output->status = 'OK';
} else {
  $output->status = 'NOK';
}

echo json_encode($output);


