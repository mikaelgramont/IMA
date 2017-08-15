<style>
	.results-container {
		width: 300px;
	}

	dl {
		margin: 20px 0;
	}

	table {
		width: 250px;
		margin: 20px auto;
	}

	caption {
		font-size: 1.5em;
	}

	td:first-child {
		text-align: right;
		padding-right: 3px;
	}

	tr:nth-child(odd) {
		background: #e4dac3;
		color: #000;
	}
</style>

<div class="results-container">
<?php
	$years = PageHelper::getAvailableYears();

	$yearArg = "year";
	if (!isset($_GET[$yearArg])) {
		$currentYear = $years[0];
	} else {
		$currentYear = $_GET[$yearArg];
		if (!in_array($_GET[$yearArg], $years)) {
			throw new Exception("No results for year '{$currentYear}'");
		}
	}
	
	echo "<p>Displaying results for year $currentYear</p>";
	foreach ($years as $year) {
		$url = BASE_URL . "results?$yearArg=" . $year;
		if ($currentYear != $year) {
			echo "<a href='$url'>$year</a>\n";
		} else {
			echo "$year\n";
		}
	}
	echo "<div class='results-container'>\n";
	require(RESULTS_HTML_PATH . $currentYear . ".php");
	echo "</div>\n";
?>
</div>