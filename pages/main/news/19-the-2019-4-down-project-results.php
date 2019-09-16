<?php
require('SpreadsheetReader.php');

define('VOTE_SPREADSHEET_ID', '1_rm2C7QDPEvgbouvsXol6SZs1W1pO0r91QWfeE-Dno0');
define('VOTE_CACHE_NAME', '4-down-2019-results');
define('USE_VOTE_CACHE', false);
define('VOTE_CACHE_DURATION', 1 * 60);

$baseUrl = BASE_URL;

$possibleChoicesJson = <<<JSON
[
  {
    "index": 0,
    "displayName": "Terra NoZóio",
    "spreadsheetName": "The Brazilan crew's “Terra NoZóio”",
    "image": "${baseUrl}images/news/19-4-down-results/thumb0.jpg",
    "authors": "",
    "teaserUrl": "",
    "videoUrl": "https://www.youtube.com/watch?v=Zu-Xy8RheTE",
    "barColor": "rgb(220, 57, 18)"
  },
  {
    "index": 1,
    "displayName": "The Hangover",
    "spreadsheetName": "The French crew's “The Hangover / Very Board Trip”",
    "image": "${baseUrl}images/news/19-4-down-results/thumb1.jpg",
    "authors": "",
    "teaserUrl": "",
    "videoUrl": "https://www.youtube.com/watch?v=3O4kq9PlIsM",
    "barColor": "rgb(16, 150, 24)"
  },
  {
    "index": 2,
    "displayName": "Muscle Memory",
    "spreadsheetName": "Nicky Geerse's “Muscle Memory”",
    "image": "${baseUrl}images/news/19-4-down-results/thumb2.jpg",
    "authors": "",
    "teaserUrl": "",
    "videoUrl": "https://www.youtube.com/watch?v=zAJtvk3jI-s",
    "barColor": "rgb(255, 153, 0)"
  },
  {
    "index": 3,
    "displayName": "Everywhere I go",
    "spreadsheetName": "The Polish crew's “Everywhere I go”",
    "image": "${baseUrl}images/news/19-4-down-results/thumb3.jpg",
    "authors": "",
    "teaserUrl": "",
    "videoUrl": "https://www.youtube.com/watch?v=3XRFFUkmnFs",
    "barColor": "rgb(51, 102, 204)"
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

    $ret->votes = array_values($anonymousVotes);
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

<style>
    .primary {
        background: #E82020;
        display: inline-block;
        border-radius: .5em;
        padding: .5em;
        color: #fff;
        text-decoration: none;
        font-size: 1.3em;
    }

    .primary:hover {
        cursor: pointer;
    }

    #trigger {
        margin: 0 auto 20px;
        display: block;
    }

    .animation-started #trigger {
        display: none;
    }

    .animation-started .hidden-after-animation-started {
        display: none;
    }

    .visible-only-after-animation-started {
        display: none;
    }

    .animation-started .visible-only-after-animation-started {
        display: initial;
    }

    #vote-animation {
    }

    .visible-after-animation {
        display: none;
    }

    .animation-finished .visible-after-animation {
        display: initial;
    }

    .animation-content,
    .button-container {
        display: none;
    }

    .animation-started .animation-content {
        display: initial;
    }
    .graph {
        display: flex;
        margin: 0 auto;
        background: #ddd;
        flex-wrap: nowrap;
        max-width: 500px;
        height: 250px;
    }

    .graph-bar-wrapper {
        flex: 1 0;
        position: relative;
    }

    .graph-bar {
        margin: 0 20px;
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
    }

    .graph-thumb {
        margin: 0 auto 10px;
        position: absolute;
        border-radius: 50%;
        background-position: center;
        background-size: cover;
        width: 64px;
        height: 64px;
        left: 0;
        right: 0;
        border: 3px solid currentColor;
    }

    .date {
        text-align: center;
        margin: 0 0 10px;
    }

    .results-table {
        background: #ddd;
        margin: 10px auto;
        padding: 10px;
    }

    .nameCell {
        display: flex;
    }

    .tallyCell {
        width: 100px;
        text-align: right;
    }

    .coloredSquare {
        display: inline-block;
        width: 1em;
        height: 1em;
        position: relative;
        top: 1px;
    }

    .itemLink {
        display: inline-block;
        margin-left: .25em;
    }

</style>

<h1 class="display-font">The results of the 2019 4 Down video contest are in!</h1>
<p>If you've missed the whole thing, head over to <a href="<?php echo BASE_URL?>news/18-the-2019-4-down-project">the news page detailing the contest and this year's videos</a>.</p>

<p>Before we even get into it, allow us to thank the athletes and the talented film makers who put a lot of work into this project!</p>

<p>

</p>
<p class="hidden-after-animation-started">
  Because it was fun last year, let's reuse the little animation to let everyone go through the race! Click the button below:
</p>

<h1 class="display-font visible-only-after-animation-started">
    Detailed results
</h1>

<div id="vote-animation"
     data-startClass="animation-started"
     data-endClass="animation-finished"
     data-scrollTo="results-content">
    <p>Loading...</p>
</div>

<div id="results-content" class="visible-after-animation">
    <h1 class="display-font">And the winner is: The Brazilan crew with “Terra NoZóio”!</h1>
    <p>
        Congratulations to Lucas Melo, Thiago Solon, and crew!
    </p>
    <p>
        Second place goes to the French crew with “The Hangover", congratulations to them as well!
    </p>
    <p>
        Let's be honest, the videos are all great in their own right, and beyond the quality, a big factor into the results is how the videos
        were shared on social media. So one lesson for the future: social media presence is important!
    </p>
</div>


<script>
    var voteData = <?php echo json_encode($displayData); ?>;
    var items = <?php echo $possibleChoicesJson ?>;
</script>
<script src="<?php echo BASE_URL?>scripts/vote-animation-bundle.js"></script>
