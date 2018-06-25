<?php
	// Displaying a news article.
	$param = PAGE_PARAMS[0];
    if (strpos($param, '..') !== false) {
        throw new Exception('Path is unsafe');
    }

	// Format: baz-foo-bar;
	$htmlFile = NEWS_HTML_PATH . $param . ".html";
	$phpFile = NEWS_HTML_PATH . $param . ".php";

	if (file_exists($phpFile)) {
        // TODO: execute file and display results
        require_once($phpFile);
    } else if (file_exists($htmlFile)) {
        $content = file_get_contents($htmlFile);
        $parts = explode(NEWS_SEPARATOR, $content);

        echo $parts[2];
    } else {
        $errorMsg = "No news by that name found";
    }

