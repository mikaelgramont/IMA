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
List of all the <a href="<?php echo BASE_URL ?>newsletter-content">potential content for IMA newsletters </a>