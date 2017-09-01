<?php
if (isset($_REQUEST['error'])) {
	$errorMessage = Utils::escape(urldecode($_REQUEST['error']));
	echo "<p class=\"paragraph\">{$errorMessage}</p>";
} else {
	switch ($_REQUEST['type']) {
		case 'results':
			echo "<p class=\"paragraph\">Results were updated successfully!</p>";
			echo "<p class=\"paragraph\"><a href=\"".BASE_URL."results\">Check them out!</a></p>";
			break;
		case 'events':
			echo "<p class=\"paragraph\">Events were updated successfully!</p>";
			echo "<p class=\"paragraph\"><a href=\"".BASE_URL."events\">Check them out!</a></p>";
			break;
	}
}