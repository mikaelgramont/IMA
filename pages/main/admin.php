<h1 class="display-font">Administration</h1>

<h2 class="display-font">Results</h2>
<form action="<?php echo BASE_URL ?>perform-update" method="POST">
	<span class="paragraph">Press this button to update the listings of competition results:</span>
	<input type="hidden" name="type" value="results">
	<input type="submit" value="Update">
</form>

<h2 class="display-font">Events</h2>
<form action="<?php echo BASE_URL ?>perform-update" method="POST">
	<span class="paragraph">Press this button to update the calendar:</span>
	<input type="hidden" name="type" value="events">
	<input type="submit" value="Update">
</form>

<h2 class="display-font">Newsletter content</h2>
<p>List of all the <a href="<?php echo BASE_URL ?>newsletter-content">potential content for IMA newsletters </a>.</p>

<h2 class="display-font">WFC 2019 registration list</h2>
<p>The <a href="https://docs.google.com/spreadsheets/d/1_EyP3om_4al0q_i6lo6pHg6Epw-kCvjUTi1ZRWmcCiI/edit#gid=0" target="_blank">list of registered riders</a>, with payment info.</p>

<h2 class="display-font">Event update form</h2>
<p>A quick <a href="<?php echo BASE_URL ?>event-update-form">form to post updates during an event</a>.</p>