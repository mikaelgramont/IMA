<?php
	// Displaying a news article.
	$param = PAGE_PARAMS[0];
	// Format: baz-foo-bar;
	$file = NEWS_HTML_PATH . $param . ".php";
	if (!file_exists($file)) {
		$errorMsg = "No news by that name found";
	}
	
	$content = file_get_contents($file);
	$parts = explode(NEWS_SEPARATOR, $content);

	echo $parts[1];
