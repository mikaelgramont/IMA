<?php
// Displaying a news article.
$param = PAGE_PARAMS[0];
if (strpos($param, '..') !== false) {
  throw new Exception('Path is unsafe');
}

$phpFile = NEWS_HTML_PATH . $param . ".php";
if (file_exists($phpFile)) {
  // Execute PHP file
  require_once($phpFile);
} else if (file_exists(NEWS_HTML_PATH . $param . ".html")) {
  // Display HTML file
  $newsPage = new NewsPage(BASE_URL, NEWS_SEPARATOR, NEWS_HTML_PATH, $param . ".html");
  $newsPage->parse();
  echo '<p class="date">' . $newsPage->getDate() .'</p>';
  echo $newsPage->getContent();
} else {
  $errorMsg = "No news by that name found";
}

