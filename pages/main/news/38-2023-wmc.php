<?php
define('USE_UPDATE_CACHE', true);
define('USE_RESULT_CACHE', true);
define('UPDATE_CACHE_DURATION', 3 * 60);
define('RESULT_CACHE_DURATION', 3 * 60);
define('USE_IG_CACHE', true);

// https://www.unixtimestamp.com/index.php
// One month before 07/11/2023 @ 12:00am (UTC)
define('START_DATE_TIMESTAMP', 1689076800 - 24 * 3600 * 30 * 1);

// 07/18/2023 @ 12:00am (UTC)
define('END_DATE_TIMESTAMP', 1689804000);

define('LIVE_UPDATES_SPREADSHEET_ID', '1rC05_jbglJY8wYgvC6YyVAVkbewQMy3cwIOiGqcu68w');
define('LIVE_UPDATES_CACHE_NAME', 'wmc23-live-updates');

define('RESULTS_SPREADSHEET_ID', '1rC05_jbglJY8wYgvC6YyVAVkbewQMy3cwIOiGqcu68w');
define('RESULTS_CACHE_NAME', 'wmc23-live-results');

/*
  If you want to see what it looks like in www.eeb-it.co.uk/results
  There will be the following separate sheets:
  - Freestyle Results
  - BoarderX Results
  - Downhill Results
  - Overall Results
  Freestyle will have the following tabs:
  - Pro Qualifying
  - Am Finals
  - Pro Finals
  BoarderX will have the following tabs:
  - Qualifying Races
  - Qualifying Results
  - Knockout Races
  - Final Results
  Downhill will have the following tabs:
  - Qualifying Results
  - Final Results
  Overall will be a single tab
 */
$resultSections = json_decode(<<<JSON
  [
    {
      "label": "Freestyle",
      "items": [{
          "label": "Pro Qualifying",
          "sheetLink": "https://docs.google.com/spreadsheets/d/1aXBywV6AvNLSCheePdsna3y9_f1hcEBFxI1ysk2fGo4/",
          "idInSheetValues": 0
        }, {
          "label": "Amateur Finals",
          "sheetLink": "https://docs.google.com/spreadsheets/d/1aXBywV6AvNLSCheePdsna3y9_f1hcEBFxI1ysk2fGo4/#gid=294622686",
          "idInSheetValues": 1
        }, {
          "label": "Pro Finals",
          "sheetLink": "https://docs.google.com/spreadsheets/d/1aXBywV6AvNLSCheePdsna3y9_f1hcEBFxI1ysk2fGo4/#gid=2046312317",
          "idInSheetValues": 2
        }]
    }, {
      "label": "Boardercross",
      "items": [{
          "label": "Qualifying Races",
          "sheetLink": "https://docs.google.com/spreadsheets/d/1ZzPu23NpNDQBmyRrZ8gYMJhmfMqJgsUIvZYTi8vbWbk/#gid=2084874141",
          "idInSheetValues": 4
        }, {
          "label": "Qualifying Results",
          "sheetLink": "https://docs.google.com/spreadsheets/d/1ZzPu23NpNDQBmyRrZ8gYMJhmfMqJgsUIvZYTi8vbWbk/#gid=177550960",
          "idInSheetValues": 5
        }, {
          "label": "Knockout Races",
          "sheetLink": "https://docs.google.com/spreadsheets/d/1ZzPu23NpNDQBmyRrZ8gYMJhmfMqJgsUIvZYTi8vbWbk/#gid=287599021",
          "idInSheetValues": 6
        }, {
          "label": "Final Results",
          "sheetLink": "https://docs.google.com/spreadsheets/d/1ZzPu23NpNDQBmyRrZ8gYMJhmfMqJgsUIvZYTi8vbWbk/#gid=1464872807",
          "idInSheetValues": 7
        }]
    }
  ]
JSON
);

/*
 Downhill event data:
{
      "label": "Downhill",
      "items": [{
          "label": "Qualifying Results",
          "sheetLink": "https://docs.google.com/spreadsheets/d/1Vw3n6EPE_QL4nQaCefE8tAMJEpvnpqEvg4mRROCDfqo/#gid=1797972878",
          "idInSheetValues": 9
        }, {
          "label": "Final Results",
          "sheetLink": "https://docs.google.com/spreadsheets/d/1Vw3n6EPE_QL4nQaCefE8tAMJEpvnpqEvg4mRROCDfqo/#gid=1087506671",
          "idInSheetValues": 10
        }]
    }
 */

function getUpdates() {
    $pool = Cache::getPool();
    $cacheItem = $pool->getItem(LIVE_UPDATES_CACHE_NAME);
    if (USE_UPDATE_CACHE) {
        if ($cacheItem->isMiss()) {
            $updates = retrieveUpdateObjects();
            $cacheItem->lock();
            $cacheItem->set($updates);
            $cacheItem->expiresAfter(UPDATE_CACHE_DURATION);
            $pool->save($cacheItem);
        } else {
            $updates = $cacheItem->get();
        }
    } else {
        $updates = retrieveUpdateObjects();
    }

    return $updates;
}

function retrieveUpdateObjects() {
    $updates = array();
    try {

        if (!file_exists(CREDENTIALS_PATH)) {
            throw new Exception("No token file");
        } else {
            try {
                $accessToken = json_decode(file_get_contents(CREDENTIALS_PATH), true);
            } catch (Exception $e) {
                throw new Exception("Could not decode the token");
            }
        }

        $client = Helpers::getGoogleClientForWeb($accessToken);
        $sheetsService = new Google_Service_Sheets($client);
        $range = "A2:C";
        $sheetContentResponse = $sheetsService->spreadsheets_values->get(LIVE_UPDATES_SPREADSHEET_ID, $range);
        $values = $sheetContentResponse->getValues();
        foreach ($values as $index => $value) {
            $update = new stdClass();
            $update->author = $value[0];
            $update->date = $value[1];
            $update->content = $value[2];
            $updates[] = $update;
        }
    } catch (Exception $e) {
        // Should log something somewhere -- ain't nobody got time for that.
    }
    return array_reverse($updates);
}

function renderUpdate($count, $update) {
    $class = $count === 0 ? "first" : "";
    $title = $count === 0 ? 'Latest update - '.$update->date : 'Update - '.$update->date;

    $html = <<<HTML
    <li class="${class}">
        <h2 class="display-font update-title">{$title}</h2>
        <pre class="update-content">{$update->content}</pre>
        <p class="update-author">
            {$update->author}
        </p>
    </li>
        
HTML;
    return $html;
}

function getResults() {
  $pool = Cache::getPool();
  $cacheItem = $pool->getItem(RESULTS_CACHE_NAME);
  if (USE_RESULT_CACHE) {
    if ($cacheItem->isMiss()) {
      $results = retrieveResultObjects();
      $cacheItem->lock();
      $cacheItem->set($results);
      $cacheItem->expiresAfter(RESULT_CACHE_DURATION);
      $pool->save($cacheItem);
    } else {
      $results = $cacheItem->get();
    }
  } else {
    $results = retrieveResultObjects();
  }

  return $results;
}

function retrieveResultObjects() {
  $results = array();
  try {

    if (!file_exists(CREDENTIALS_PATH)) {
      throw new Exception("No token file");
    } else {
      try {
        $accessToken = json_decode(file_get_contents(CREDENTIALS_PATH), true);
      } catch (Exception $e) {
        throw new Exception("Could not decode the token");
      }
    }

    $client = Helpers::getGoogleClientForWeb($accessToken);
    $sheetsService = new Google_Service_Sheets($client);
    $range = "Results!C2:C12";
    $sheetContentResponse = $sheetsService->spreadsheets_values->get(RESULTS_SPREADSHEET_ID, $range);
    $values = $sheetContentResponse->getValues();
    foreach ($values as $value) {
      $results[] = $value[0];
    }
  } catch (Exception $e) {
    // Should log something somewhere -- ain't nobody got time for that.
  }
  return $results;

}

function renderResultSection($count, $section, $results) {
  $content = "";
  foreach ($section->items as $item) {
    $content .= renderResultItem($item, $results);
  }

  if (!$content) {
    return "";
  }

  $html = <<<HTML
    <ul class="result-section">
      <h3 class="display-font">{$section->label}</h3>
      {$content}
    </ul>
        
HTML;
  return $html;
}

function renderResultItem($item, $results) {
  $ready = $results[$item->idInSheetValues] !== "No";
  if (!$ready) {
    return "";
  }
  $link = "<a target=\"_blank\" href=\"$item->sheetLink\">{$item->label}</a>";
  $html = <<<HTML
    <li class="result-item">
      {$link}
    </li>
        
HTML;
  return $html;
}

$updates = getUpdates();
$results = getResults();
?>
<style>
    .live-main {
        margin-top: 0;
        padding: 0;
        list-style-type: none;
    }

    .live-main h2 {
        background: #1A1705;
        color: #fff;
        margin-left: -.5em;
        padding: .25em .5em;
    }

    .live-main .first h2 {
        background: #E82020;
        color: #fff;
    }

    .update-content {
        font-family: 'Raleway';
        white-space: pre-wrap;
    }

    .result-links {
      margin: 1rem 0;
    }

    .result-section {
      list-style: none;
      padding: 0;
      margin: 0 0 1rem 0;
    }

    .result-item {
      list-style: none;
      padding: .5rem .5rem .5rem 0;
    }

    @media screen and (min-width: 1000px) {
        .live-content {
            display: flex;
            width: 100%;
            flex-wrap: nowrap;
        }
        .live-main {
            flex: 1 0;
        }

        .live-main {
            margin-right: 20px;
        }

        .result-section {
          margin: 0 1rem;
        }

    }
</style>


<section>
    <h1 class="display-font">World Mountainboard Championship 2023 (July 11th-15th) - live coverage</h1>
    <p>We'll be posting updates and live results as the event takes place, so come back often!</p>

    <p>
      If you're looking for the <a href="<?php echo BASE_URL ?>news/37-2023-world-champs">competition schedule, look here</a>.
    </p>

    <section class="result-links">
      <h2 class="display-font update-title">Live Results</h2>

<?php
      $resultContent = "";
      foreach($resultSections as $count => $resultSection) {
        $resultContent .= renderResultSection($count, $resultSection, $results);
      }
      if ($resultContent) {
        echo '<ul class="live-content">';
        echo $resultContent;
        echo '</ul>';
      } else {
        echo"No results available yet.";
      }
?>
    </section>

    <section class="live-content">
      <ul class="live-main">
<?php
          foreach($updates as $count => $update) {
            echo renderUpdate($count, $update);
          }
?>
      </ul>
    </section>
</section>
