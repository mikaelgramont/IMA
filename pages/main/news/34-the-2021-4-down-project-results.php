<?php
require('SpreadsheetReader.php');

define('VOTE_SPREADSHEET_ID', '1w9QBHWQ-ctT9NfbgDQcvkiq01Z0hOT5HmH76ku-6JSg');
define('VOTE_CACHE_NAME', '4-down-2021-results');
define('USE_VOTE_CACHE', false);
define('VOTE_CACHE_DURATION', 1 * 60);

$baseUrl = BASE_URL;

$possibleChoicesJson = <<<JSON
[
  {
    "index": 0,
    "displayName": "Del Cielo a la Tierra",
    "spreadsheetName": "The Costa Rican crew's “Del Cielo a la Tierra”",
    "image": "${baseUrl}images/news/34-4-down-results/1.jpg",
    "authors": "",
    "teaserUrl": "",
    "videoUrl": "https://www.youtube.com/watch?v=vVgnZDCq-qc",
    "barColor": "rgb(220, 57, 18)"
  },
  {
    "index": 1,
    "displayName": "It's All Downhill From Here",
    "spreadsheetName": "The South African crew's “It's All Downhill From Here”",
    "image": "${baseUrl}images/news/34-4-down-results/2.jpg",
    "authors": "",
    "teaserUrl": "",
    "videoUrl": "https://www.youtube.com/watch?v=_hLjHWQhkbo",
    "barColor": "rgb(16, 150, 24)"
  },
  {
    "index": 2,
    "displayName": "From Dust Till Downhill",
    "spreadsheetName": "The Swiss crew's “From Dust till Downhill“",
    "image": "${baseUrl}images/news/34-4-down-results/3.jpg",
    "authors": "",
    "teaserUrl": "",
    "videoUrl": "https://www.youtube.com/watch?v=1F9lQBz5-j4",
    "barColor": "rgb(255, 153, 0)"
  },
  {
    "index": 3,
    "displayName": "Mountain ВЙО!",
    "spreadsheetName": "The Ukrainian crew's “Mountain ВЙО!“",
    "image": "${baseUrl}images/news/34-4-down-results/4.jpg",
    "authors": "",
    "teaserUrl": "",
    "videoUrl": "https://www.youtube.com/watch?v=ba1T6qyavHc",
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

    $startTime = mktime(16, 0, 0, 8, 18, 2021);
    $startDate = null;
    $endTime = mktime(0, 0, 0, 9, 1, 2021);
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
    .balance {
      width: 250px;
      float: left;
      margin: 10px 10px 10px 0;
    }
    @media screen and (max-width: 640px) {
      .balance {
        width: 160px;
      }
    }

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

<h1 class="display-font">The results of the 2021 4 Down Project are in!</h1>
<p>
  For background on the 4 Down Project <a href="<?php echo BASE_URL?>news/33-the-2021-4-down-project-videos">check out our last news article</a>.
</p>

<p>
  Before revealing this year's winner, we'd like to thank everyone involved in this 4th edition of the contest:
  the athletes, the filming and editing crews, and the people who worked with them. We know how much work went into
  each and every one of these videos, and we're very grateful.
</p>

<h2 class="display-font">Our sponsor this year</h2>
<img src="<?php echo BASE_URL?>images/news/33-the-2020-4-down-project-videos/balance.png" alt="Balance logo" class="balance"/>
<p>
  All of us here at the IMA would like to thank <a href="https://www.balance-2010.com">Balance Japan</a> for supporting
  the 2021 4 Down Project!
</p>

<p>
  Without companies like them the sport of mountainboarding wouldn't be where it is today. They started selling
  mountainboards in the 90’s and have pushed the sport not only in their own country but globally. They have recently
  released their <a href="https://www.balance-2010.com/shop/p-01trucks.html#ptrdw2pro97">“Hybrid Hanger”</a>. The top
  truck adapter to run old-style aluminum top trucks on the newer Matrix 2 axles. Having seen them in person they are
  top notch construction and a welcomed addition to those looking to retrofit Matrix 2’s with their existing Matrix
  top trucks!<br>
  If you haven’t seen them check out their online store for more information and to browse through all of your
  mountainboard needs and follow their instagram for the most recent mountainboard content:
  <a href="https://www.instagram.com/balance.jp">@balance.jp</a>
</p>

<h2 class="display-font">The results</h2>
<p class="hidden-after-animation-started">
  Click the button below to see a retrospective of the voting over the two-week voting period:
</p>

<div id="vote-animation"
     data-startClass="animation-started"
     data-endClass="animation-finished"
     data-scrollTo="results-content">
    <p>Loading...</p>
</div>

<div id="results-content" class="visible-after-animation">
    <h1 class="display-font">And the winner is... Del Cielo a la Tierra !!!</h1>
    <p>
        Note: we cut off voting at 0:00 on Wednesday September 1st (Paris time).
    </p>
    <p>
      Congratulations to the Costa Rican team - James González Valle, Marco Dixon, Giancarlo Navas, Rolando Chinchilla
      Dinarte! Our first Central American contestants clearly made a big impression and we're very happy to award them
      this victory!
    </p>
    <p>
      Many thanks to all teams for sharing with the community their wonderful videos. They gave us inspiration and
      something to look forward to in a year that has been tough for many. Thank you for your time, your effort, and
      opening our eyes to what mountainboarding means to you!
    </p>
    <p>
      The 4 Down Project is over for now but we’ll see you again in 2022, in Australia, for the premiere of the
      5th edition!
    </p>
</div>


<script>
    var voteData = <?php echo json_encode($displayData); ?>;
    var items = <?php echo $possibleChoicesJson ?>;
</script>
<script src="<?php echo BASE_URL?>scripts/vote-animation-bundle.js"></script>
