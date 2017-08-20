<?php
	$years = PageHelper::getAvailableYears();
	if (empty($years)) {
		throw new Exception("No available results.");
	}
	$yearArg = "year";
	if (!isset($_GET[$yearArg])) {
		$currentYear = $years[0];
	} else {
		$currentYear = $_GET[$yearArg];
		if (!in_array($_GET[$yearArg], $years)) {
			throw new Exception("No results for year '{$currentYear}'");
		}
	}
?>
<style>
	.results-title {
		display: flex;
		flex-wrap: nowrap;
		align-items: center;
	}

	.results-title__h1 {
		display: inline-block;
		flex-shrink: 0;
		margin-right: 15px;
		/* Compensate for empty space at the top of letters in the font. */
		position: relative;
		top: -2px;
	}

	.results-title__year-list {
		display: inline-flex;
		padding: 0;
		font-size: 1.5em;
		margin: 0;
		/*flex-wrap: wrap;*/
		/* Use this instead of flex-wrap to get horizontal scrolling, to be styled with .is-overflowing */
		overflow-x: auto;
	}

	.results-title__year-list.is-overflowing::after {
		content: "...";
		position: absolute;
		right: 0;
		font-size: .8em;
		margin-top: .25em;
	}

	.results-title__year-list__entry {
		flex: 1 0;
		list-style: none;
		text-align: center;	
		margin: 0 .5em;
	}

	.results-title__year-list__entry__content {
		padding: 0 .5em;
		border-radius: 1.5em;
		text-decoration: none;
	}

	.results-title__year-list__entry .selected {
		background: #E82020;
		color: #F7F7F7;
	}

	.results-entry {
		margin-bottom: 30px;
	}

	.entry-title {
		margin-bottom: 15px;
	}

	.category-list {
		margin: 0 0 0 10px;
		padding: 0;
		list-style: none;
		display: flex;
    	flex-wrap: wrap;		
	}

	.category {
	    margin: 0 auto 30px;
		width: 300px;
    	padding: 0 5px;
    	box-sizing: border-box;
	}
	.category-name {
		color: #E82020;
	}

	@media screen and (min-width: 640px) {
		.category {
    		width: 50%;
		    margin: 0 0 30px;
    	}
	}
	table {
		width: 100%;
		border-collapse: collapse;
	}

	caption {
		margin-bottom: .5em;
		text-align: left;
	}

	caption a {
		color: #E82020;
		text-decoration: none;
		font-weight: bold;
	}

	td {
		border: 1px solid #d8d8d8;
		padding: 5px;
	}

	.position {
		width: 20px;
		text-align: center;	
	}

	.fullname {
		font-weight: bold;
	}
	.no-highlight .fullname {
		font-weight: normal;
	}

	.hidden-result {
		display: none;
	}
	table.expanded .hidden-result {
		display: table-row;
	}

	.expand-cell {
		text-align: center;
		font-weight: normal;
	}
	.expand-cell-button {
		padding: 3px 6px;
		border: 0;
		opacity: .8;
		background: transparent;		
	}
	.expand-cell-button:hover {
		cursor: pointer;
	}
	expand-cell
</style>


<div class="page-title-container results-title">
	<h1 class="results-title__h1 display-font">Competition results</h1>
	<ol class="results-title__year-list">

<?php
	foreach ($years as $year) {
		$url = BASE_URL . "results?$yearArg=" . $year;
		echo "<li class=\"results-title__year-list__entry\">\n";
		if ($currentYear != $year) {
			echo "<a class=\"display-font results-title__year-list__entry__content\" href='$url'>$year</a>\n";
		} else {
			echo "<div class=\"display-font results-title__year-list__entry__content selected\">$year</div>\n";
		}
		echo "</li>\n";
	}
?>
	</ol>
</div>
<?php	
	echo "<div class='results'>\n";
	require(RESULTS_HTML_PATH . $currentYear . ".php");
	echo "</div>\n";
?>
<script>
	/* Detect overflow in the list of years, and apply a class to make scrolling obvious */
	(function() {
		var listEl = document.getElementsByClassName('results-title__year-list')[0];

		var isOverflowing = function() {
			return listEl.scrollWidth > listEl.clientWidth;
		};

		var makeOverflowObvious = function() {
			listEl.classList.toggle("is-overflowing", isOverflowing());
		};
		window.addEventListener("load", makeOverflowObvious);
		window.addEventListener('resize', makeOverflowObvious);

		// CLICK ON EXPAND BUTTONS
	    on('.wrapper', 'click', '.expand-cell-button', function(e) {
	    	function getTableParent(child) {
	    		if (child.parentNode.tagName == 'TABLE') {
	    			return child.parentNode;
	    		} else {
	    			return getTableParent(child.parentNode);
	    		}
	    	}
	    	var buttonEl = e.target;
	    	var tableEl = getTableParent(buttonEl);
	    	if (buttonEl.innerText == buttonEl.getAttribute('data-collapsed-text')) {
	    		tableEl.classList.add('expanded');
	    		buttonEl.innerText = buttonEl.getAttribute('data-expanded-text');
	    	} else {
				tableEl.classList.remove('expanded');
				buttonEl.innerText = buttonEl.getAttribute('data-collapsed-text');
	    	}
	    });
	})();
</script>