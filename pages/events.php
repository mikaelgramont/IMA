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
	<pre>
		<?php
			echo var_export(PAGE_PARAMS, true);
		?>
	</pre>
<?php

require(EVENTS_HTML_PATH . "events.php");
?>
</div>