<?php
	function generateYearChangeForm($years, $currentYear) {
		$action = BASE_URL . "results";
		$options = array();
		foreach ($years as $year) {
			$selected = $year == $currentYear ? " selected=\"selected\"" : "";
			$options[] = "<option $selected value=\"$year\">$year</option>";
		}
		$options = implode("\n", $options);

		$out = <<<HTML
		<form id="year-form" class="year-form" action="{$action}" method="GET">
			<select id="year-select" name="year">
				{$options}
			</select>
		</form>
HTML;
		return $out;
	}

	$errorMsg = "";
	$years = PageHelper::getAvailableYears();
	$showEmbedForm = false;
	if (empty($years)) {
		throw new Exception("No available results.");
	}

	if (empty(PAGE_PARAMS)) {
		$isYearMode = true;
		// Displaying a whole year
		$yearArg = "year";
		if (!isset($_GET[$yearArg])) {
			$currentYear = $years[0];
		} else {
			$currentYear = $_GET[$yearArg];
			if (!in_array($_GET[$yearArg], $years)) {
				$errorMsg = "No results for year '{$currentYear}'";
			}
		}
		$resultsFile = RESULTS_HTML_PATH . $currentYear . ".php";
		if (!file_exists($resultsFile)) {
			$errorMsg = "No results file for year '{$currentYear}'";
		}
	} else {
		$isYearMode = false;
		// Displaying a single event's results.
		$resultsParam = PAGE_PARAMS[0];
		// Format: 2017-foo-bar;
		$resultsFile = RESULTS_HTML_PATH . $resultsParam . ".php";
        if (!isset($pageInfo->embed)) {
            $showEmbedForm = true;
            $embedUrl = $resultsParam;
        }
	}
?>
<style>
<?php
    if (isset($pageInfo->embed)) {
?>

    .navigation-menu,
    .footer,
    .page-title-container,
    .page-title-container.with-cta {
        display: none;
    }
    .banner {
        width: 165px;
        height: 43px;
        margin: 15px 0 0;
    }

<?php
    }
?>
	.year-form {
		margin: 0;
	} 
	.year-form select {
		font-size: 16px;
	}
	.results-entry {
		margin-bottom: 30px;
	}

	.entry-title {
		margin-bottom: 15px;
	}

	.category-list {
		margin: 0px;
		padding: 0;
		list-style: none;
		display: flex;
    	flex-wrap: wrap;		
	}

	.category {
	  margin: 0 auto 10px;
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
	<?php
		if (!$isYearMode) {
	?>
		.link-icon {
			display: none;
		}
	<?php
		}
	?>
    .embed-area {
        margin: 0 auto 30px;
        max-width: 400px;
    }
    .embed {
        width: 100%;
        height: 4em;
    }
    #copy-status {
        color: #E82020;
    }
</style>


<div class="page-title-container with-cta results-title">
	<h1 class="results-title__h1 display-font">Competition results</h1>
	<?php
		if ($isYearMode) {
			echo generateYearChangeForm($years, $currentYear);
		}
	?>
</div>
<?php
	if ($errorMsg) {
		echo "<p>".$errorMsg."</p>\n";
	} else {
		echo "<div class=\"results\">\n";
		require($resultsFile);
		echo "</div>\n";
	}

	if ($showEmbedForm) {
?>
        <div class="embed-area">
            <p>To share these results on your website, insert the following HTML code in your page:</p>
            <textarea readonly class="embed" id="embed-textarea"><iframe src="<?php echo BASE_URL.'results-embed/'.$resultsParam ?>" border="0" style="max-width: 600px; height: 500px"></iframe>            </textarea>
            <span id="copy-status" hidden>The embed was code copied in the clipboard!</span>
        </div>
<?php
    }
?>
<script>
	(function() {
		<?php
			if ($isYearMode) {
		?>
		document.getElementById("year-select").addEventListener("change", function() {
			document.getElementById("year-form").submit();
		});
		<?php
			} else {
		?>
            var embed = document.getElementById("embed-textarea");
            if (embed) {
                embed.addEventListener("focus", function() {
                    embed.select();
                    document.execCommand('copy');
                    document.getElementById('copy-status').hidden = false;
                });
            }
        <?php
            }

		?>
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