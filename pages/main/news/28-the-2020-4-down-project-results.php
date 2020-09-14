<?php
require('SpreadsheetReader.php');

define('VOTE_SPREADSHEET_ID', '1IYrC59VLC7TEqhPJnUvQgweJfPmSCKI4NNsN5M8Ufe0');
define('VOTE_CACHE_NAME', '4-down-2020-results');
define('USE_VOTE_CACHE', false);
define('VOTE_CACHE_DURATION', 1 * 60);

$baseUrl = BASE_URL;

$possibleChoicesJson = <<<JSON
[
  {
    "index": 0,
    "displayName": "Drifters",
    "spreadsheetName": "The Japanese crew's “Drifters”",
    "image": "${baseUrl}images/news/28-4-down-results/thumb0.jpg",
    "authors": "",
    "teaserUrl": "",
    "videoUrl": "https://www.youtube.com/watch?v=sUFiqJ_ycRQ",
    "barColor": "rgb(220, 57, 18)"
  },
  {
    "index": 1,
    "displayName": "Spirit",
    "spreadsheetName": "The Portuguese crew's “Spirit”",
    "image": "${baseUrl}images/news/28-4-down-results/thumb1.jpg",
    "authors": "",
    "teaserUrl": "",
    "videoUrl": "https://www.youtube.com/watch?v=CRDZlyfF2-Q",
    "barColor": "rgb(16, 150, 24)"
  },
  {
    "index": 2,
    "displayName": "The Cherries On Top Of The Cake",
    "spreadsheetName": "The Romanian crew's “The Cherries On Top Of The Cake“",
    "image": "${baseUrl}images/news/28-4-down-results/thumb2.jpg",
    "authors": "",
    "teaserUrl": "",
    "videoUrl": "https://www.youtube.com/watch?v=aFyFLfCMdFY",
    "barColor": "rgb(255, 153, 0)"
  },
  {
    "index": 3,
    "displayName": "Summer Camp",
    "spreadsheetName": "The US crew's “Summer Camp“",
    "image": "${baseUrl}images/news/28-4-down-results/thumb3.jpg",
    "authors": "",
    "teaserUrl": "",
    "videoUrl": "https://www.youtube.com/watch?v=TEkt41v-MPc",
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

    $startTime = mktime(9, 0, 0, 9, 1, 2020);
    $startDate = null;
    $endTime = mktime(0, 0, 0, 9, 14, 2020);
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

<h1 class="display-font">The results of the 2020 4 Down Project are in!</h1>
<p>For background on the 4 Down Project <a href="<?php echo BASE_URL?>news/27-the-2020-4-down-project">check out our last news article</a>.</p>

<p>
  Before revealing this year's winner, we'd like to thank everyone involved in this 3rd edition of the contest:
  the athletes, the filming and editing crews, and the people who worked with them. We know how much work went into
  each and every one of these videos, and we're very grateful.
</p>

<p>
  Like last year, this year's contest is sponsored by
  <a href="https://www.surfingdirt.com" target="_blank">Surfing Dirt</a>, the online community for mountainboarders!<br>
  First prize gets $300, second prize gets $200!
</p>

<p class="hidden-after-animation-started">
  Click the button below to see a retrospective of the voting over the two-week voting period:
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
    <h1 class="display-font">And the winner is... The Cherries On Top Of The Cake !!!</h1>
    <p>
        Note: we cut off voting at 9:00 on Monday September 14th (Paris time).
    </p>
    <p>
      Congratulations to the Romanian team - Sonia Nicolau, Erica Pintea, Tamara Susa - on the win! The first all-female
      mountainboard project painted a portrait of mountainboarding focused on exploration and progression. Sonia and
      Erica put this edit together despite being separated by the COVID crisis but were still able to tell their story.
    </p>
    <p>
      Many thanks to all teams for sharing with the community their wonderful videos. They gave us inspiration and
      something to look forward to in a year that has been tough for many. Thank you for your time, your effort, and
      opening our eyes to what mountainboarding means to you!
    </p>
    <p>
      The 4 Down Project might be over for now but we’ll see you again in 2021, in Compiegne, for the premiere of the
      4th edition!
    </p>
</div>


<script>
    var voteData = <?php echo json_encode($displayData); ?>;
    var items = <?php echo $possibleChoicesJson ?>;
</script>
<script src="<?php echo BASE_URL?>scripts/vote-animation-bundle.js"></script>
