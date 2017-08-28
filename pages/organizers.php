<?php
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
$files = Helpers::getFileList($service, PUBLIC_DOCUMENTS_FOLDER_ID);
?>

<style>
  .description {
    margin-bottom: 0;
  }
  .file-list {
    padding: 0;
    margin-left: 20px;  
    list-style: none;
  }
  .file {
    margin-bottom: 15px;
  }
  .file-link {
    display: inline-block;
    margin: 0 0 5px -20px;
    line-height: 16px;
    text-decoration: none;
    font-weight: bold;
  }
  .file-link > * {
    vertical-align: middle;
  }
  .date {
    font-size: 0.75em;
    opacity: .6;
  }
  @media screen and (max-width: 640px) {
    .description {
      text-align: left;
    }
  }
</style>
<div class="page-title-container">
  <h1 class="display-font">Resources for Organizers</h1>
</div>

<h2 class="display-font">Event submission form</h1>
<p class="paragraph">
  In order to submit a new event, please follow the <a href="<?php echo EVENT_SUBMISSION_FORM_URL ?>">event submission form</a>.
</p>

<h2 class="display-font">Documents</h1>
<p class="paragraph">
  Below is a list of documents the IMA has prepared over the years, which we hope will be useful for organizing events, building venues and promoting mountainboarding in general.
</p>
  <?php
  if (count($files) == 0) {
    echo "<p>No files.</p>\n";
  } else {
    echo "<ul class=\"file-list\">\n";
    foreach ($files as $file) {
      $t = date_parse($file["modifiedTime"]);
      $date = $t["year"] . "-" . $t["month"] . "-" . $t["day"] . " " . $t["hour"]. ":" . $t["minute"]. ":" . $t["second"];

      echo "<li class=\"file\">\n" . renderDocument(
        $file["webViewLink"],
        $file["mimeType"],
        $file["iconLink"],
        $file["name"],
        $file["description"],
        $date,
        $file["id"]
      ). "</li>\n";
    }
    print "</ul>\n";
  }
  
  function renderDocument($url, $mimeType, $image, $title, $description, $date, $id)
  {
      $image = $image ? "<img src=\"{$image}\" alt=\"\">" : "";
      $description = $description ? "<p class=\"paragraph description\">{$description}</p>" : "";

    return <<<HTML
      <a class="file-link" href="{$url}" title="{$mimeType}" data-id=\"$id\">
        {$image}
        <span class="title">{$title}</span>
      </a>
      <div class="file-metadata">
        {$description}
        <span class="date">Last modified: {$date}</span>
      </div>
HTML;
  }
