<?php
define('PHOTO_COLUMN_COUNT', 3);
define('PHOTO_COUNT', 7 * PHOTO_COLUMN_COUNT);

define('USE_IG_CACHE', true);

define('IG_IMA_USERNAME', INSTAGRAM_USERNAME);
define('IG_IMA_CACHE_NAME', 'username-ima-photos');

define('IG_DD_USERNAME', 'dirtdessert');
define('IG_DD_CACHE_NAME', 'username-dirtdessert-photos');

define('IG_TAG', 'wmc18');
define('IG_TAG_CACHE_NAME', 'tag-mountainboard-photos');

// https://www.unixtimestamp.com/index.php
// One month before 06/24/2018 @ 12:00am (UTC)
define('START_DATE_TIMESTAMP', 1529798400 - 24 * 3600 * 30 * 1);

// 07/03/2018 @ 12:00am (UTC)
define('END_DATE_TIMESTAMP', 1530576000);

$blacklist = array(
    '1809104206020640981',
    '1809100982766555938',
    '1809419175796377008',
    '1807190928029481297',
);

function renderItem($data) {
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

    $html = <<<HTML
    <li class="stream-photo">
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

$pool = Cache::getPool();
$allPhotos = array();

$IMAScraper = new Instagram(IG_IMA_USERNAME, $pool, $blacklist, USE_IG_CACHE, IG_IMA_CACHE_NAME);
$IMAPhotos = $IMAScraper->getPhotos();

$DDScraper = new Instagram(IG_DD_USERNAME, $pool, $blacklist, USE_IG_CACHE, IG_DD_CACHE_NAME);
$DDPhotos = $DDScraper->getPhotos();

$tagScraper = new InstagramTag(IG_TAG, $pool, $blacklist, USE_IG_CACHE, IG_TAG_CACHE_NAME);
$tagScraper->enforceTagPresence('mountainboard');
$tagPhotos = $tagScraper->getPhotos();

$allPhotos = array_merge($IMAPhotos, $DDPhotos, $tagPhotos);
$allPhotos = array_filter($allPhotos, function($photo) {
    return $photo->timestamp > START_DATE_TIMESTAMP && $photo->timestamp < END_DATE_TIMESTAMP;
});
uasort($allPhotos, 'compareTimestamps');
$photos = array_slice($allPhotos, 0, PHOTO_COUNT + 1);

?>

<style>
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
    }
</style>

<section>
    <h1 class="display-font">World Mountainboard Championship 2018 - live coverage</h1>
    <p>We'll be adding updates as the event takes place, so come back often!</p>

    <div class="live-content">
        <div class="live-main">
            <h2 class="display-font">Update - June 25th</h2>
            <p>
                The very first riders are starting to show up, and it will soon look like the annual WMC gathering we've all come to love.<br>
                In the meantime, the rain this morning meant that the track was wet and athletes retreated to Kranj's pumptrack.
            </p>
            <p>
                The track is looking great by the way! The Dirt Dessert team has put in a ton of work (and not just on the track, but also the surrounding areas), and we're looking forward to the event!<br>
                We'll be putting finishing touches over the next couple of days, and then it's on!
            </p>
            <p>
                The forecast does call for some rain showers until Thursday, but has us in the clear with nice weather and high temperatures for the actual competition!
            </p>
            <p>
                If you're coming, bring bug spray (watch out for mosquitoes and ticks!) as well as sunscreen! See you soon!
            </p>
            <p class="author">
                Mika
            </p>
        </div>
        <div class="ig-stream">
            <h2 class="display-font">The WMC on Instagram</h2>
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
    echo "<li class=\"stream-photo\"></li>\n";
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