<?php
define('CURRENT_EVENT', 'WFC2019');
$config = EventUpdates::getConfig(CURRENT_EVENT);

define('PHOTO_COLUMN_COUNT', 2);
define('PHOTO_COUNT', 80 * PHOTO_COLUMN_COUNT);

define('USE_UPDATE_CACHE', false);
define('UPDATE_CACHE_DURATION', 5 * 60);
define('USE_IG_CACHE', true);

define('IG_IMA_USERNAME', INSTAGRAM_USERNAME);
define('IG_IMA_CACHE_NAME', 'username-ima-photos');

define('IG_ORGANISER_USERNAME', 'mountainboardinfo');
define('IG_ORGANISER_CACHE_NAME', 'username-mountainboardinfo-photos');

define('IG_TAG', 'wfc19');
define('IG_TAG_CACHE_NAME', 'tag-mountainboard-photos');

// https://www.epochconverter.com/
// Wednesday, 1 July 2019 09:00:00
define('START_DATE_TIMESTAMP', 1561971600);

// Thursday, 8 August 2019 09:00:00
define('END_DATE_TIMESTAMP', 1565254800);

define('LIVE_UPDATES_SPREADSHEET_ID', '15ImD2LEHH9C6Is2taoL7ZnDa6ZHnJAT2zZhqWxZsw6U');
define('LIVE_UPDATES_CACHE_NAME', $config->cacheId);
define('LIVE_UPDATES_RANGE', $config->range);


$blacklist = array(
);

function renderItem($data) {
    if (!$data) {
        return '<li class="stream-photo placeholder"></li>';
    }
    $href = 'https://www.instagram.com/p/' . $data->shortcode;
    $noHashtagArray = explode('#', $data->title);
    $title = $noHashtagArray[0];


    $comment = '';
    if ($data->commentCount == 1) {
        $comment = '1 comment';
    } else if ($data->commentCount > 1) {
        $comment = "{$data->commentCount} comments";
    }

    $like = '';
    if ($data->likeCount == 1) {
        $like = '1 like';
    } else if ($data->likeCount > 1) {
        $like = "{$data->likeCount} likes";
    }

    $parts = array();
    if ($comment) {
        $parts[] = $comment;
    }
    if ($like) {
        $parts[] = $like;
    }

    $metadata = "";
    if ($parts) {
        $metadata = '<p class="metadata">' . implode(' - ', $parts) . '</p>';
    }

    $videoClass = $data->isVideo ? " video" : "";

    $html = <<<HTML
    <li class="stream-photo{$videoClass}">
        <a target="_blank" href="{$href}">
            <img data-src="{$data->src}" data-id="{$data->id}">
            {$metadata}
        </a>
    </li>

HTML;
    return $html;
}

function compareTimestamps($a, $b) {
    if ($a->timestamp == $b->timestamp) {
        return 0;
    }

    return $a->timestamp < $b->timestamp ? 1 : -1;
}

function getPhotos($blacklist) {
    $pool = Cache::getPool();
    $IMAScraper = new Instagram(IG_IMA_USERNAME, $pool, $blacklist, USE_IG_CACHE, IG_IMA_CACHE_NAME);
    $IMAPhotos = $IMAScraper->getPhotos();

    $organiserScraper = new Instagram(IG_ORGANISER_USERNAME, $pool, $blacklist, USE_IG_CACHE, IG_ORGANISER_CACHE_NAME);
    $organiserPhotos = $organiserScraper->getPhotos();

    $tagScraper = new InstagramTag(IG_TAG, $pool, $blacklist, USE_IG_CACHE, IG_TAG_CACHE_NAME);
    $tagScraper->enforceTagPresence('mountainboard');
    $tagPhotos = $tagScraper->getPhotos();

    $allPhotos = array_merge($IMAPhotos, $organiserPhotos, $tagPhotos);
    $allPhotos = array_filter($allPhotos, function($photo) {
        return $photo->timestamp > START_DATE_TIMESTAMP && $photo->timestamp < END_DATE_TIMESTAMP;
    });
    uasort($allPhotos, 'compareTimestamps');
    $allPhotos = array_slice($allPhotos, 0, PHOTO_COUNT + 1);

    $dedupedPhotos = array();
    $prevShortcode = null;
    foreach($allPhotos as $photo) {
        if ($photo->shortcode != $prevShortcode) {
            $dedupedPhotos[] = $photo;
        }
        $prevShortcode = $photo->shortcode;
    }
    return $dedupedPhotos;
}

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
        $sheetContentResponse = $sheetsService->spreadsheets_values->get(LIVE_UPDATES_SPREADSHEET_ID, LIVE_UPDATES_RANGE);
        $values = $sheetContentResponse->getValues();
        foreach ($values as $index => $value) {
            $update = new stdClass();
            $update->author = $value[0];
            $update->date = $value[1];
            $update->title = $value[2];
            $update->message = $value[3];
            $update->photo = $value[4];
            $updates[] = $update;
        }
    } catch (Exception $e) {
        // Should log something somewhere -- ain't nobody got time for that.
    }
    return array_reverse($updates);
}

function renderUpdate($count, $update) {
    $class = $count === 0 ? "first" : "";
    $banner = $count === 0 ? 'Latest update - '.$update->date : 'Update - '.$update->date;
    $img = "";
    if ($update->photo) {
      $src = BASE_URL . $update->photo;
      $img = <<<IMG
      <img class="update-photo" src={$src} alt="" />
IMG;

    }

    $message = nl2br(Utils::autoLink(htmlentities($update->message)));
    $html = <<<HTML
    <li class="${class}">
        <h2 class="display-font update-banner">{$banner}</h2>
        <p class="update-title">{$update->title}</p>
        <p class="update-content">{$message}</p>
        <p class="update-author">
            {$update->author}
        </p>
        {$img}
    </li>
        
HTML;
    return $html;
}

$photos = getPhotos($blacklist);
$updates = getUpdates();
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

    .live-main .first .update-banner {
        background: #E82020;
        color: #fff;
    }

    .update-title {
      margin: .5rem 0;
      font-weight: bold;
    }

    .update-content {
        font-family: 'Raleway';
    }

    .update-photo {
      max-width: 100%;
      margin-bottom: 20px;
    }

    .stream {
        display: flex;
        width: 100%;
        flex-wrap: wrap;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .stream-photo {
        flex: 200px 1 0;
        margin-right: 10px;
        margin-bottom: 10px;
        position: relative;
        height: 390px;
    }

    .stream-photo.video::after {
        content: " ";
        display: block;
        background: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB2aWV3Qm94PSIwIDAgNjAgNjAiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDYwIDYwOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8Zz4NCgk8cGF0aCBmaWxsPSIjZWVlIiBkPSJNNDUuNTYzLDI5LjE3NGwtMjItMTVjLTAuMzA3LTAuMjA4LTAuNzAzLTAuMjMxLTEuMDMxLTAuMDU4QzIyLjIwNSwxNC4yODksMjIsMTQuNjI5LDIyLDE1djMwDQoJCWMwLDAuMzcxLDAuMjA1LDAuNzExLDAuNTMzLDAuODg0QzIyLjY3OSw0NS45NjIsMjIuODQsNDYsMjMsNDZjMC4xOTcsMCwwLjM5NC0wLjA1OSwwLjU2My0wLjE3NGwyMi0xNQ0KCQlDNDUuODM2LDMwLjY0LDQ2LDMwLjMzMSw0NiwzMFM0NS44MzYsMjkuMzYsNDUuNTYzLDI5LjE3NHogTTI0LDQzLjEwN1YxNi44OTNMNDMuMjI1LDMwTDI0LDQzLjEwN3oiLz4NCgk8cGF0aCBmaWxsPSIjZWVlIiBkPSJNMzAsMEMxMy40NTgsMCwwLDEzLjQ1OCwwLDMwczEzLjQ1OCwzMCwzMCwzMHMzMC0xMy40NTgsMzAtMzBTNDYuNTQyLDAsMzAsMHogTTMwLDU4QzE0LjU2MSw1OCwyLDQ1LjQzOSwyLDMwDQoJCVMxNC41NjEsMiwzMCwyczI4LDEyLjU2MSwyOCwyOFM0NS40MzksNTgsMzAsNTh6Ii8+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8L3N2Zz4NCg==');
        background-size: 50%;
        background-repeat: no-repeat;
        background-position: 50% 50%;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        pointer-events: none;
    }

    .stream-photo img {
        max-width: 100%;
    }

    .stream-photo a {
        text-decoration: none;
    }

    .stream-photo .metadata {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        line-height: 1.3em;
        vertical-align: middle;
        background: rgba(0, 0, 0, .8);
        color: #eee;
        margin: 0;
        padding: 0.5em;
    }

    @media screen and (min-width: 1000px) {
        .live-content {
            display: flex;
            width: 100%;
            flex-wrap: nowrap;
        }
        .live-main,
        .ig-stream {
            flex: 1 0;
        }

        .live-main {
            margin-right: 20px;
        }

        .stream-photo {
            height: 225px;
        }
    }
</style>


<section>
    <h1 class="display-font">World Freestyle Championship 2019 (July 26th-27th) - live coverage</h1>
    <p>We'll be adding updates as the event takes place, so come back often!</p>

    <p>
        For schedule information, check out <a href="https://wfc.mountainboardworld.org/competition" target="_blank">the timeline on the official event site</a>.
    </p>

    <div class="live-content">
        <ul class="live-main">
<?php
            foreach($updates as $count => $update) {
                echo renderUpdate($count, $update);
            }
?>
        </ul>
        <div class="ig-stream">
            <h2 class="display-font">The WFC on Instagram</h2>
<?php
$i = 0;
echo '<ul class="stream">';
foreach($photos as $photo) {
    if (in_array($photo->id, $blacklist)) {
     continue;
    }
    echo renderItem($photo)."\n";
    $i++;
}
while($i % PHOTO_COLUMN_COUNT > 0 ) {
    echo renderItem(null)."\n";
    $i++;
}
echo '</ul>';
?>
        </div>
    </div>
</section>
<script>
    let imageNodes = Array.prototype.slice.call(document.getElementsByTagName('img'));

    const intersectionObserver = new IntersectionObserver(
        onIntersectionObservation,
        { rootMargin: '0px 0px 300px 0px' } // preload all images that are in the viewport and 1000px below "the fold".
    );
    imageNodes.forEach( ( imageNode ) => intersectionObserver.observe( imageNode ) );

    function onIntersectionObservation( entries, observer ) {
        entries
            .filter(  ( entry ) => entry.target.hasAttribute( 'data-src' ) && entry.isIntersecting )
            .forEach( ( entry ) => {
                // swap data-src and src
                entry.target.setAttribute( 'src', entry.target.getAttribute( 'data-src' ) );
                entry.target.removeAttribute( 'data-src' );
                observer.unobserve( entry.target );
            } )
        ;
    }

</script>