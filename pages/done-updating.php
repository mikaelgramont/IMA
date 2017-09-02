<style>
	.error {
		color: #E82020;
	}

</style>
<?php
if (isset($_SESSION['update-error'])) {
	$errorMessage = $_SESSION['update-error'];
	echo "<p>There were errors, sorry!</p>";
	echo "<p class=\"paragraph error\">{$errorMessage}</p>";
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

if (isset($_SESSION['update-log'])) {	
	echo "<p>Scan log:</p>";
	echo '<pre>'.$_SESSION['update-log'].'</pre>';
}
