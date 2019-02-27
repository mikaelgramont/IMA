<?php
// Displaying a news article.
$param = PAGE_PARAMS[0];
// Format: baz-foo-bar;
$file = ARTICLES_HTML_PATH . $param . ".php";
if (!file_exists($file)) {
    $errorMsg = "No article by that name found";
}

$content = file_get_contents($file);
$parts = explode(ARTICLES_SEPARATOR, $content);

echo $parts[2];
