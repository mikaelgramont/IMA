<?php
define('DESTINATION_FOLDER', './images/uploads/');
define('PUBLIC_UPLOAD_PATH', OG_URL.'images/uploads/');

require('EventUpdates.php');

function failWithMsg($errors)
{
  $output = new stdClass();
  $output->status = 'NOK';
  $output->errors = $errors;
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

/***********************************************************************************
 * Process input data, return error if necessary
 **********************************************************************************/
$event = isset($_POST['event']) ? $_POST['event'] : null;
$date = isset($_POST['date']) ? $_POST['date'] : null;
$title = isset($_POST['title']) ? $_POST['title'] : null;
$message = isset($_POST['message']) ? $_POST['message'] : null;
$file = isset($_FILES['photo']) ? $_FILES['photo'] : null;

$errors = [];
$config = EventUpdates::getConfig($event);
if (!$config) {
  $errors['Configuration'] = 'bad event';
}

if (!$date) {
  $errors['Date'] = 'missing';
}
if (!$message) {
  $errors['Message'] = 'missing';
}
if ($errors) {
  failWithMsg($errors);
}

/***********************************************************************************
 * File upload management
 **********************************************************************************/
$filename = Utils::uuidV4().'.jpg';
$filePath = DESTINATION_FOLDER . $filename;
$photoPublicUrl = PUBLIC_UPLOAD_PATH . $filename;

if (!move_uploaded_file($_FILES['photo']['tmp_name'], $filePath)) {
  $errors['Photo'] = 'a problem occurred during upload';
}

if ($errors) {
  failWithMsg($errors);
}

/***********************************************************************************
 * Spreadsheet management
 **********************************************************************************/
$errorMessage = "";
if (!file_exists(CREDENTIALS_PATH)) {
  $errorMessage = "No token file";
} else {
  try {
    $accessToken = json_decode(file_get_contents(CREDENTIALS_PATH), true);
  } catch (Exception $e) {
    $errorMessage = "Could not decode the Google API token";
  }
}
if ($errorMessage) {
  failWithMsg([$errorMessage]);
}

$client = Helpers::getGoogleClientForWeb($accessToken);
$sheetsService = new Google_Service_Sheets($client);
$logger = new Logger();
$spreadsheetId = $config->spreadsheetId;


/***********************************************************************************
 * Update
 **********************************************************************************/
$update = [
  $date,
  $title,
  $message,
  $photoPublicUrl,
];

try {
  EventUpdates::save($sheetsService, $spreadsheetId, $update);
} catch (Google_Exception $e) {
  failWithMsg($e->getMessage());
}

//TODO: Bust cache

success();




