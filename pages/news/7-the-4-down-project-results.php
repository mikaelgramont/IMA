<?php
require('SpreadsheetReader.php');

define('VOTE_SPREADSHEET_ID', '1Qbe00JyfoniKsTZgUqUdIN75FMHmHpEG_euoE7zXoIs');
define('VOTE_CACHE_NAME', '4-down-2018-results');
define('USE_VOTE_CACHE', false);
define('VOTE_CACHE_DURATION', 1 * 60);

$baseUrl = BASE_URL;

$possibleChoicesJson = <<<JSON
[
  {
    "index": 0,
    "displayName": "Strapless",
    "spreadsheetName": "Mason Moore's “Strapless”",
    "image": "${baseUrl}images/news/8-video-thumb1.jpg",
    "authors": "",
    "teaserUrl": "",
    "videoUrl": "https://www.youtube.com/watch?v=xlDiG45zcak",
    "barColor": "rgb(16, 150, 24)"
  },
  {
    "index": 1,
    "displayName": "The Dark Side of Riding with a Champion",
    "spreadsheetName": "Amon Shaw's “The Dark Side of Riding with a Champion”",
    "image": "${baseUrl}images/news/8-video-thumb2.jpg",
    "authors": "",
    "teaserUrl": "",
    "videoUrl": "https://www.youtube.com/watch?v=PKSj3GY3u0M",
    "barColor": "rgb(220, 57, 18)"
  },
  {
    "index": 2,
    "displayName": "Arrived",
    "spreadsheetName": "Dylan Warren's \"Arrived\"",
    "image": "${baseUrl}images/news/8-video-thumb3.jpg",
    "authors": "",
    "teaserUrl": "",
    "videoUrl": "https://www.youtube.com/watch?v=znUgVO6k6wg",
    "barColor": "rgb(51, 102, 204)"
  },
  {
    "index": 3,
    "displayName": "Never Pro - Always Bro",
    "spreadsheetName": "Phil Elnieh's “Never Pro - Always Bro”",
    "image": "${baseUrl}images/news/8-video-thumb4.jpg",
    "authors": "",
    "teaserUrl": "",
    "videoUrl": "https://www.youtube.com/watch?v=Dh0iQ8eKT8Q",
    "barColor": "rgb(255, 153, 0)"
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
    }

    .nameCell {
        display: flex;
    }

    .tallyCell {
        width: 90px;
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

<h1 class="display-font">The results of the 4-down video contest are in!</h1>
<p>If you've missed the whole thing, head over to <a href="<?php echo BASE_URL?>news/6-the-4-down-project">the news page about the 4 Down video project</a>.</p>


<p>Before we reveal the name of winning video and team, let us tell you one thing: it was tight!</p>

<p>Everyone's done a good job of engaging with the community and their circle of friends and followers, so no matter what happens, it means one thing: more visibility for mountainboarding, and that'a great thing!</p>

<p>
    Because we've been watching this so closely and couldn't tell who was going to win, we thought we'd let you live the same experience by playing votes back (much faster).
</p>
<p class="hidden-after-animation-started">
    So without further ado, press the button below and see who won!
</p>

<h2 class="display-font visible-only-after-animation-started">
    This is what the voting process looked like
</h2>

<div id="vote-animation"
     data-startClass="animation-started"
     data-endClass="animation-finished"
     data-scrollTo="results-content">
    <p>Loading...</p>
</div>

<div id="results-content" class="visible-after-animation">
    <h1 class="display-font">And the winner is: XXX!</h1>
    <p>
        Congratulations to YYYY! We know they put a lot of work into their video edit and it showed!
    </p>
    <p>
        They've already committed to putting the prize money of $500 provided by <a href="https://www.colabtmtb.com>">Colab</a> to good use for mountainboarding!
    </p>
    <p>
        Seeing how close this battle was, it's safe to say that all videos were great and everyone found their public! Thank you very much to all of you who worked on your video submission!
    </p>

    <h1 class="display-font">From here on</h1>
    <p>
        The IMA's already expressed our desire to run this contest again for 2019. The video premiere at the WFC was very well received and it made for a really nice start of for the event.
    </p>
    <p>
        However, the big idea here was for this to be a way to kickstart more high-quality content creation for mountainboarding in general.<br>
        Over the last few years, we've all seen the signs of the community slowing down and we'd like to help change that, bring back the stoke, and have everyone push each other!
    </p>
    <p>
        So look forward to more things like the 4 Down video contest in the future!
    </p>
</div>


<script>
    var voteData = <?php echo json_encode($displayData); ?>;
    var items = <?php echo $possibleChoicesJson ?>;
</script>
<script src="<?php echo BASE_URL?>scripts/vote-animation-bundle.js"></script>
