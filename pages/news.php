<?php
// Displaying a news article.
$param = PAGE_PARAMS[0];
if (strpos($param, '..') !== false) {
  throw new Exception('Path is unsafe');
}

?>
<style>
  .news-article p {
    text-align: justify;
  }
  .news-title-wrapper {
    display: flex;
    align-items: center;
    flex-direction: row;
  }

  .news-date {
    margin-left: 0.5em;
  }
</style>
<div class="news-article">
<?php

$phpFile = NEWS_HTML_PATH . $param . ".php";
if (file_exists($phpFile)) {
  // Execute PHP file
  require_once($phpFile);
} else if (file_exists(NEWS_HTML_PATH . $param . ".html")) {
  // Display HTML file
  $newsPage = new NewsPage(BASE_URL, NEWS_SEPARATOR, NEWS_HTML_PATH, $param . ".html");
  $newsPage->parse(OG_URL);
  echo $newsPage->getContent();
} else {
  $errorMsg = "No news by that name found";
}

?>
</div>
