<?php
require('SpreadsheetReader.php');

define('VOTE_SPREADSHEET_ID', '1Qbe00JyfoniKsTZgUqUdIN75FMHmHpEG_euoE7zXoIs');
define('VOTE_CACHE_NAME', '4-down-2018-results');
define('USE_VOTE_CACHE', false);
define('VOTE_CACHE_DURATION', 1 * 60);

$possibleChoicesJson = <<<JSON
[
  {
    "index": 0,
    "displayName": "Strapless",
    "spreadsheetName": "Mason Moore's “Strapless”",
    "image": "",
    "authors": "",
    "teaserUrl": "",
    "videoUrl": ""
  },
  {
    "index": 1,
    "displayName": "The Dark Side of Riding with a Champion",
    "spreadsheetName": "Amon Shaw's “The Dark Side of Riding with a Champion”",
    "image": "",
    "authors": "",
    "teaserUrl": "",
    "videoUrl": ""
  },
  {
    "index": 2,
    "displayName": "Arrived",
    "spreadsheetName": "Dylan Warren's \"Arrived\"",
    "image": "",
    "authors": "",
    "teaserUrl": "",
    "videoUrl": ""
  },
  {
    "index": 3,
    "displayName": "Never Pro - Always Bro",
    "spreadsheetName": "Phil Elnieh's “Never Pro - Always Bro”",
    "image": "",
    "authors": "",
    "teaserUrl": "",
    "videoUrl": ""
  }
]
        
JSON;
$possibleChoices = json_decode($possibleChoicesJson);
$voteMap = array();
foreach ($possibleChoices as $index => $choice) {
    $voteMap[$choice->spreadsheetName] = $index;
}

function sortTimestampsOlderFirst($a, $b) {
    if ($a->timestamp == $b->timestamp) {
        return 0;
    }

    return $a->timestamp > $b->timestamp ? 1 : -1;
}

function getVoteIndex($choiceName, $voteMap) {
    if (!isset($voteMap[$choiceName])) {
        throw new Exception("Could not understand vote '$choiceName'");
    }
    return $voteMap[$choiceName];
}

function getDisplayData($votes, $voteMap) {
    $ret = new stdClass();
    $anonymousVotes = array();

    $startTime = mktime(0, 0, 0, 0, 0, 2020);
    $startDate = null;
    $endTime = mktime(0, 0, 0, 0, 0, 2017);
    $endDate = null;

    foreach ($votes as $vote) {
        $voteObject = new stdClass();
        $voteObject->date = $vote[0];
        $voteObject->timestamp = Utils::datetimeToTimestamp($vote[0]);
        $voteObject->choice = getVoteIndex($vote[2], $voteMap);
        $anonymousVotes[] = $voteObject;

        if ($voteObject->timestamp < $startTime) {
            $startTime = $voteObject->timestamp;
            $startDate = $voteObject->date;
        }
        if ($voteObject->timestamp > $endTime) {
            $endTime = $voteObject->timestamp;
            $endDate = $voteObject->date;
        }
    }

    uasort($anonymousVotes, 'sortTimestampsOlderFirst');

    $ret->votes = $anonymousVotes;
    $ret->startTime = $startTime;
    $ret->startDate = $startDate;
    $ret->endTime = $endTime;
    $ret->endDate = $endDate;

    return $ret;
}

function readSpreadsheet() {
    $rawVotes = SpreadsheetReader::readRange(CREDENTIALS_PATH, VOTE_SPREADSHEET_ID, 'A2:C');
    return $rawVotes;
}

function getCachedVotes() {
    $pool = Cache::getPool();
    $cacheItem = $pool->getItem(VOTE_CACHE_NAME);
    if (USE_VOTE_CACHE) {
        if ($cacheItem->isMiss()) {
            $votes = readSpreadsheet();
            $cacheItem->lock();
            $cacheItem->set($votes);
            $cacheItem->expiresAfter(VOTE_CACHE_DURATION);
            $pool->save($cacheItem);
        } else {
            $votes = $cacheItem->get();
        }
    } else {
        $votes = readSpreadsheet();
    }

    return $votes;
}

$cachedVotes = getCachedVotes();
$displayData = getDisplayData($cachedVotes, $voteMap);
$cachedVotes = null;
?>

<h1 class="display-font">The results of the 4-down video contest are in!</h1>
<p>Who do you think won, huh?</p>

<div id="vote-animation">
    <p>Loading</p>
</div>

<p>Was that epic or what?</p>

<script>
    var voteData = <?php echo json_encode($displayData); ?>;
    var items = <?php echo $possibleChoicesJson ?>;
</script>
<script src="<?php echo BASE_URL?>scripts/vote-animation-bundle.js"></script>
