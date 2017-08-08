<?php
require_once __DIR__.'/../php/config.php';
require_once 'Helpers.php';

if (!file_exists(CREDENTIALS_PATH)) {
  throw new Exception("No token file at " . CREDENTIALS_PATH);
}
try {
  $accessToken = json_decode(file_get_contents(CREDENTIALS_PATH), true);
} catch (Exception $e) {
  throw new Exception("Could not decode the token at " . CREDENTIALS_PATH);
}

// Get the API client and construct the service object.
$client = Helpers::getGoogleClientForWeb($accessToken);
$service = new Google_Service_Drive($client);

// Print the names and IDs for up to 10 files.
$optParams = array(
  'pageSize' => 10,
  'fields' => 'nextPageToken, files(id, name, modifiedTime)'
);
$results = $service->files->listFiles($optParams);

if (count($results->getFiles()) == 0) {
  print "No files found.\n";
} else {
  print "Files:\n";
  print "<ul>\n";
  foreach ($results->getFiles() as $file) {
    printf("<li>%s (%s) - %s</li>\n", $file->getName(), $file->getId(), $file->getModifiedTime());
  }
  print "</ul>\n";
}