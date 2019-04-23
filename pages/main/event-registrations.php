<?php
// Displaying a news article.
$param = PAGE_PARAMS[0];
// Format: baz-foo-bar;
$file = EVENT_REGISTRATION_HTML_PATH . $param . ".php";
if (!file_exists($file)) {
  $errorMsg = "No interview by that name found";
}

//ob_start();
include $file;
//$content = ob_get_contents();
//ob_end_clean();
//
//echo $content;
