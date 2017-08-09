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

$files = Helpers::getFileList($service);
$details = Helpers::getDetailedFileList($service, $files);

//echo '<pre>'.var_export($details, true).'</pre>';


if (count($details) == 0) {
  print "<p>No files found.</p>\n";
} else {
  print "<p>Files:</p>\n";
  print "<ul>\n";
  foreach ($details as $file) {
    printf(
      "<li><a href='%s'><img src='%s' alt=''>%s</a>- %s</li>\n",      
      $file["webViewLink"],
      $file["iconLink"],
      $file["name"],
      date("Y-m-d H:i:s", $file["modifiedTime"])
    );
  }
  print "</ul>\n";
}