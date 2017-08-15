<style>
	.events-container {
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

<div class="events-container">
<?php
require(EVENTS_HTML_PATH . "events.php");
?>
</div>