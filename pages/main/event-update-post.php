<?php
//require_once('FacebookPagePost.php');

define('DESTINATION_FOLDER', './images/uploads/');
define('PUBLIC_UPLOAD_PATH', '/images/uploads/');

function failWithMsg($errors)
{
  $output = new stdClass();
  $output->status = 'NOK';
  $output->errors = $errors;
  echo json_encode($output);
  exit();
}

function success($destination)
{
  $output = new stdClass();
  $output->status = 'OK';
  $output->redirect = $destination;
  echo json_encode($output);
  exit();
}

/***********************************************************************************
 * Process input data, return error if necessary
 **********************************************************************************/
$event = isset($_POST['event']) ? $_POST['event'] : null;
$author = isset($_POST['author']) ? $_POST['author'] : null;
$date = isset($_POST['date']) ? $_POST['date'] : null;
$title = isset($_POST['title']) ? $_POST['title'] : null;
$message = isset($_POST['message']) ? $_POST['message'] : null;
$file = isset($_FILES['photo']) ? $_FILES['photo'] : null;

$errors = [];
$config = EventUpdates::getConfig($event);
$pageUrl = BASE_URL . $config->pagePath;
if (!$config) {
  $errors['Configuration'] = 'bad event';
}

if (!$author) {
  $errors['Author'] = 'missing';
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
$photoPublicUrl = null;
if ($file) {
  $filename = Utils::uuidV4() . '.jpg';
  $filePath = DESTINATION_FOLDER . $filename;
  $photoPublicUrl = PUBLIC_UPLOAD_PATH . $filename;

  if (!move_uploaded_file($_FILES['photo']['tmp_name'], $filePath)) {
    $errors['Photo'] = 'a problem occurred during upload';
  }

  if ($errors) {
    failWithMsg($errors);
  }
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
  failWithMsg(['Google Api' => $errorMessage]);
}

$client = Helpers::getGoogleClientForWeb($accessToken);
$sheetsService = new Google_Service_Sheets($client);
$spreadsheetId = $config->spreadsheetId;

/***********************************************************************************
 * Update
 **********************************************************************************/
$update = [
  $author,
  $date,
  $title,
  $message,
  $photoPublicUrl,
];

try {
  EventUpdates::saveToGoogleSheets($sheetsService, $spreadsheetId, $update);
} catch (Google_Exception $e) {
  failWithMsg(['Google Sheets' => $errorMessage]);
}

try {
  EventUpdates::bustCache($config->cacheId);
} catch (Google_Exception $e) {
  failWithMsg(['Cache' => $errorMessage]);
}

/***********************************************************************************
 * FB post
 **********************************************************************************/
//$content = <<<CONTENT
//${title}
//
//${content}
//
//${author}
//CONTENT;
//
//try {
//  FacebookPagePost::postMessage(FB_APP_ID, FB_APP_SECRET, $content, $pageUrl, $photoPublicUrl);
//} catch (Exception $e) {
//  failWithMsg($e->getMessage());
//}

success($pageUrl);




