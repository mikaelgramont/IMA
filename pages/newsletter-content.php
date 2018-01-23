<style>
	#seed {
		display: none;
	}
	.entry-action:hover {
		cursor: pointer;
	}

	.expand-button {
		display: inline-block;
    	vertical-align: middle;
    	margin: .25em;		
	}
	.arrow {
	  width: 0; 
	  height: 0; 
	  border-left: .5em solid transparent;
	  border-right: .5em solid transparent;
	}
	.arrow-up {
	  border-bottom: .5em solid #000;
	}

	.arrow-down {
	  border-top: .5em solid #000;
	}

	/* Controls */
	.controls-wrapper {
		margin: 1em 0;
	}
 	.control {
 		display: inline-block;
 		margin: 0 1em 0;
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
	.discarded-row:hover,
	.used-row:hover {
		opacity: 1;
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
	.preview-header {
		display: inline-flex;
		width: 100%;
	}
	.preview-header:hover {
		cursor: pointer;	
	}
	.textarea-label {
		display: block;
	}
	.preview-content {
		display: none;
		margin-top: 1em;
	}
	.preview-content.expanded {
		display: flex;
	}
	@media (max-width: 640px) {
		.preview-content.expanded {
			display: block;
		}
	}	
	.image-container {
		width: 240px;
		margin: 0 .5em .5em 0;
	}
	.preview .image {
		max-width: 100%;
	}
	.info-container {
		flex: 1 0;
	}
	.info-container textarea {
		width: 100%;
		font-size: 1em;
	}
	.preview-title-text {
		font-size: 1em;
		flex: 1 0;
		margin: 0;
	}
	@media (max-width: 640px) {
		.preview-title-text {
			word-break: break-all;
		}
	}

	.actions > *{
		vertical-align: middle;
		margin: .25em;
	}
	.entry-action {
		display: inline-block;
    	margin: .25em;
		color: #fff;
		background: #E82020;
		border: 2px solid #C80000;
		font-size: 1em;		
	}
	@media (max-width: 640px) {
		.entry-action {
			margin: .5em;
		}
	}

	.preview .link {
		word-break: break-all;
		display: inline-block;
		margin-left: .25em;	
	}
	.preview .footer-text {
		opacity: .5;
    	font-size: .875em;		
	}
</style>

<h1 class="display-font">Newsletter content</h1>

<p>The table below lists all content submitted by the IMA team or by other people through the <a href="https://goo.gl/forms/SttmTw5GlazKxvgA3">external form</a>.</p>

<p>TODO</p>
<ul>
	<li>Escaping</li>
	<li>Add admin auth check</li>
	<li>Productionize JS</li>
	<li>Fix caching</li>
	<li>Add proper loading icon</li>
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
	$sheetsService = new Google_Service_Sheets($client);
	$logger = new Logger();
	$spreadsheetId = NEWSLETTER_CONTENT_SPREADSHEET_ID;
	
	$ogInfo = OGInfoCache::getInstance(OGINFO_PATH);
	
	// We want to see next month's issue on first load.
	$monthStartTime = strtotime(date('Y-M') . '+1 Month');

	$contentList = NewsletterContentParser::buildContentList($sheetsService, $logger, $spreadsheetId, $ogInfo, $monthStartTime);
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

