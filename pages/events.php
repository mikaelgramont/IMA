<?php
if (empty(PAGE_PARAMS)) {
	$isListMode = true;
	// Displaying all upcoming events.
	$file = EVENTS_HTML_PATH . "events.php";
	if (!file_exists($file)) {
		$errorMsg = "No events page found";
	}
} else {
	$isListMode = false;
	// Displaying a single event.
	$eventParam = PAGE_PARAMS[0];
	// Format: baz-foo-bar;
	$file = EVENTS_HTML_PATH . $eventParam . ".php";
	if (!file_exists($file)) {
		$errorMsg = "No event by that name found";
	}
}

if ($isListMode) {
	?>
		<style>
		.event {
		    margin-bottom: 30px;
		}
		</style>
		<div class="page-title-container with-cta display-font">
		  <h1 class="display-font">Upcoming events</h1>
		  	<div class="cta">
		  		<a href="<?php echo EVENT_SUBMISSION_FORM_URL ?>">New event</a>
			</div>
		</div>


		<div class="events-container">
		<?php
			require($file);
		?>
		</div>	
	<?php
} else {
	?>
		<div class="events-container">
		<?php
			require($file);
		?>
		</div>
	<?php
}


