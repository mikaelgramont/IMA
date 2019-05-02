<?php
// Displaying a registration page.
$param = PAGE_PARAMS[0];
// Format: baz-foo-bar;
$file = EVENT_REGISTRATION_HTML_PATH . $param . ".php";
if (!file_exists($file)) {
  $errorMsg = "No interview by that name found";
}

include $file;
