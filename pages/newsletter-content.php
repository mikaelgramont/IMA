<style>
	#seed {
		display: none;
	}
	.expand-button {
		display: inline-block;
    	margin: .25em;
		color: #fff;
		background: #E82020;
		border: 2px solid #C80000;
		font-size: 1em;		
	}
	.expand-button:hover {
		cursor: pointer;	
	}

	/* Controls */
	.controls-wrapper {
		margin: 1em 0;
	}
 	.control {
 		display: inline-block;
 		margin: 0 1em 0;
 	}
 	.issueLabel{
 		display: inline-block;
 		margin-right: .25em;
 	}

	/* Table */
	.content-table {
		width: 100%;
		border-collapse: collapse;
		margin: 1em 0;
	}
	.content-table th {
		margin-bottom: .5em;
	}
	.content-table td {
		margin: 0;
		padding: .5em;
		border: 1px solid #d8d8d8;
		vertical-align: text-top;
	}
	.content-row:nth-child(odd) {
		background: #fff;
	}
	.discarded-row,
	.used-row {
		opacity: .4;
	}
	.row-status {
		font-size: .75em	;
	}

	/* Content */
	.id {
		text-align: right;
		font-family: monospace;
	}
	.timestamp {
		white-space: pre-line;
		text-align: center;
	}
	.category {
		text-align: center;
	}
	.preview-content {
		display: none;
	}
	.preview-content.expanded {
		display: initial;
	}
	.preview h2 {
		display: inline-flex;
		width: 100%;
		margin: .25em 0;
		align-items: center;
		font-size: 1em;
	}
	.entry-title {
		flex: 1 0;
	}
	.preview-content dt {
		font-weight: bold;
		margin-bottom: .25em
	}
	.preview-content dd {
		margin: 0 2em .5em;
	}
	.preview .link {
		word-break: break-all;
	}
	.preview .image {
		max-width: 100%;
	}

</style>

<h1 class="display-font">Newsletter content</h1>

<p>The table below lists all content submitted by the IMA team or by other people through the <a href="https://goo.gl/forms/SttmTw5GlazKxvgA3">external form</a>.</p>

<p>TODO</p>
<ul>
	<li>Add admin auth check</li>
	<li>Add controls fetch new data. New data updates states which re-renders.</li>
</ul>

<?php
$errorMessage = "";
if (!file_exists(CREDENTIALS_PATH)) {
	$errorMessage = "No token file";
} else {
	try {
	  $accessToken = json_decode(file_get_contents(CREDENTIALS_PATH), true);
	} catch (Exception $e) {
		$errorMessage = "Could not decode the token";
	}
}

if ($errorMessage) {
	echo "<p>There were errors, sorry!</p>";
	echo "<p class=\"paragraph error\">{$errorMessage}</p>";	
} else {
	require_once 'NewsletterContentEntry.php';
	require_once 'NewsletterContentList.php';
	require_once 'NewsletterContentParser.php';
	require_once 'OGInfoCache.php';

	// Get the API client and construct the service object.
	$client = Helpers::getGoogleClientForWeb($accessToken);
	$driveService = new Google_Service_Drive($client);
	$sheetsService = new Google_Service_Sheets($client);
	$logger = new Logger();
	$spreadsheetId = NEWSLETTER_CONTENT_SPREADSHEET_ID;
	
	$ogInfo = OGInfoCache::getInstance(OGINFO_PATH);
	
	// We want to see next month's issue on first load.
	$monthStartTime = strtotime(date('Y-M') . '+1 Month');

	$contentList = NewsletterContentParser::buildContentList($driveService, $sheetsService, $logger, $spreadsheetId, $ogInfo, $monthStartTime);
	if ($ogInfo->isDirty()) {
		$ogInfo->writeToDisk();
	}

	$contentList->issues = NewsletterContentParser::buildIssuesList(strtotime(FIRST_NEWSLETTER_MONTH));
?>
<div id="seed">
<?php echo $contentList ?>
</div>

<div id="table-container">
	<p>Loading</p>
</div>

<script src="<?php echo BASE_URL?>scripts/newsletter-content-bundle.js"></script>

	<?php
}

