<?php
use PayPalCheckoutSdk\Orders\OrdersGetRequest;

$_POST = json_decode(file_get_contents('php://input'), true);

$orderId = isset($_POST['orderID']) ? $_POST['orderID'] : null;
$client = PayPalClient::client();
$response = $client->execute(new OrdersGetRequest($orderId));

$output = new stdClass();
if ($response->result->status === 'COMPLETED') {
  $output->status = 'OK';
} else {
  $output->status = 'NOK';
}

// TODO: append raw data to a json file

// TODO: store filtered data to a spreadsheet

// TODO: send an email?

header('Content-Type: application/json');
echo json_encode($output);


