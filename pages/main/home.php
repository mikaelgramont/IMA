<?php
$pool = Cache::getPool();
$cacheId = EVENTS_CACHE_PATH;
$cacheItem = $pool->getItem($cacheId);

$eventNameEscaped = "";
$eventUrl = "";
if (!$cacheItem->isMiss()) {
  $events = $cacheItem->get();
  if ($events && sizeof($events) > 0) {
    $event = array_pop($events);
    $eventNameEscaped = Utils::escape($event->getName());
    $eventUrl = $event->getUrl();
  }
}

$photos = array();
$scraper = new Instagram(INSTAGRAM_USERNAME, $pool, array(), true, 'homepage_ig');
try {
  $photos = array_slice($scraper->getPhotos(), 0, 3);
} catch (Exception $e) {
  $photos = [];
}

$allNews = PageHelper::getNewsArticlesHTML();
$newsItems = array();
array_pop($allNews);
array_pop($allNews);
array_pop($allNews);
for ($i = 0; $i < NEWS_COUNT; $i++) {
  $newsItems[] = array_pop($allNews);
}
$news = '<ul class="news">' . implode("\n", $newsItems) . '</ul>';

?>
<style>
  .homepage-title-container {
    background: #D8D8D8;
    padding: 9px 9px;
    margin: 0 -9px 5px -9px;
  }

  .carousel-container {
    position: relative;
    margin: 0 0 20px;
  }

  .carousel {
    height: 200px;
  }

  .carousel-item {
    display: block;
    position: relative;
    height: 100%;
    background-size: cover;
  }

  .carousel-item-1 {
    background-image: url('./images/carousel/1-racing-640x342.jpg');
  }

  .carousel-item-2 {
    background-image: url('./images/carousel/2-flags-640x342.jpg');
  }

  .carousel-item-3 {
    background-image: url('./images/carousel/3-podium-640x342.jpg');
  }

  .carousel-item-4 {
    background-image: url('./images/carousel/4-wmc-640x342.jpg');
  }

  @media screen and (min-width: 640px) {
    .carousel {
      height: 513px;
    }

    .carousel-item-1 {
      background-image: url('./images/carousel/1-racing-960x513.jpg');
    }

    .carousel-item-2 {
      background-image: url('./images/carousel/2-flags-960x513.jpg');
    }

    .carousel-item-3 {
      background-image: url('./images/carousel/3-podium-960x513.jpg');
    }
  }

  .carousel-item-title {
    display: block;
    position: absolute;
    z-index: 1;
    margin: 0;
    padding: 8px;
    bottom: 0;
    width: 100%;
    background: rgba(0, 0, 0, .5);
    color: white;
  }

  .prev,
  .next {
    position: absolute;
    top: 0;
    bottom: 0;
    width: 32px;
    border: 0;
    opacity: 0;
    z-index: 2;
  }

  .prev:hover,
  .next:hover {
    cursor: pointer;
  }

  .prev {
    left: 0;
  }

  .next {
    right: 0;
  }

  .dots {
    position: absolute;
    margin: 0 auto;
    left: 0;
    right: 0;
    bottom: 45px;
    padding: 0;
    list-style: none;
    text-align: center;
  }

  .dot {
    display: inline-block;
    margin: 0 10px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #F7F7F7;
  }

  .dot.current-dot {
    background: #E82020;
  }

  /* Rest of the page */
  .content-wrapper {
    flex-wrap: nowrap;
  }

  .content-aside {
    flex: 1 0;
  }

  .news-wrapper {
    margin-bottom: 20px;
  }

  .news {
    list-style: none;
    margin: 0;
    padding: 0;
  }

  .news-link {
    text-decoration: none;
  }

  .news-link h2 {
    text-decoration: underline;
  }

  @media screen and (min-width: 640px) {
    .content-main {
    }

    .content-wrapper {
      display: flex;
    }

    .content-aside {
      margin-left: 40px;
      width: 250px;
    }
  }

  .ig-photos {
    list-style: none;
    padding: 0;
    margin: 0;
    overflow: hidden;
  }

  .ig-photo {
    margin: 15px 0;
  }

  .ig-image {
    display: block;
    width: 100%;
  }

  .ig-caption {
    display: inline-block;
    margin-top: 5px;
  }

  .newsletter-content-wrapper {
    padding-bottom: 10px;
  }

  .newsletter-link {
    text-align: center;
  }

  .link-as-button {
    background: #E82020;
    display: inline-block;
    border-radius: .5em;
    padding: .5em;
    color: #fff;
    text-decoration: none;
  }
</style>

<div id="home-carousel" class="carousel-container">
  <div class="carousel">
    <div class="carousel-item carousel-item-1">
      <a href="<?php echo BASE_URL ?>events" class="carousel-item-title">Upcoming Events</a>
    </div>
    <div class="carousel-item carousel-item-3">
      <a href="<?php echo BASE_URL ?>results" class="carousel-item-title">Competition Results</a>
    </div>
    <div class="carousel-item carousel-item-2">
      <a href="<?php echo BASE_URL ?>organizers" class="carousel-item-title">Resources for Event Organizers</a>
    </div>
  </div>
  <ul class="dots">
    <li class="dot current-dot" data-slide-id="0"></li>
    <li class="dot" data-slide-id="1"></li>
    <li class="dot" data-slide-id="2"></li>
  </ul>
  <button class="prev" aria-label="Previous"></button>
  <button class="next" aria-label="Next"></button>
</div>

<div class="content-wrapper">
  <div class="content-main">
    <?php
    if ($news) {
      ?>
      <div class="homepage-title-container">
        <h1 class="display-font">Latest news</h1>
      </div>
      <div class="news-wrapper">
        <?php echo $news; ?>
        <a href="<?php echo BASE_URL ?>archive">Older news articles</a>
      </div>
      <?php
    }
    ?>
    <h1 class="display-font homepage-title-container">Looking for mountainboarding info?</h1>
    <p class="paragraph">
      Hi there, welcome to the IMA's little corner of the internet.
    </p>
    <p class="paragraph">
      Whether you're an event organizer looking for help, or a mountainboarder looking for official IMA-sanctioned
      competition results and event calendar, we hope to provide you with the most up-to-date information.
    </p>
  </div>

  <aside class="content-aside">
    <?php
    if ($eventNameEscaped) {
      ?>
      <div class="upcoming-event">
        <h2 class="display-font homepage-title-container">Next upcoming event</h2>
        <p>
          <?php echo $eventNameEscaped; ?><br>
          <a href="<?php echo $eventUrl ?>">More info</a>
        </p>
      </div>
      <?php
    }
    ?>
    <div class="newsletter">
      <h2 class="display-font homepage-title-container">The IMA Newsletter</h2>
      <div class="newsletter-content-wrapper">
        <p>Keep up with what's going on in the community, sign up for our newsletter!</p>
        <p class="newsletter-link">
          <a class="link-as-button" href="<?php echo BASE_URL ?>newsletter">Check it out</a>
        </p>
      </div>
    </div>
    <?php
    if ($photos) {
      ?>
      <div class="ig">
        <h2 class="display-font homepage-title-container">The IMA on Instagram</h2>
        <ul class="ig-photos">
          <?php foreach ($photos as $photo) {
            echo "<li class=\"ig-photo\">\n";
            echo "<a href=\"https://www.instagram.com/p/" . $photo->shortcode . "\">\n";
            echo "<img class=\"ig-image\" src=\"" . $photo->src . "\">\n";
            echo "<span class=\"ig-caption\">" . $photo->title . "</span>\n";
            echo "</a>\n";
            echo "</li>\n";
          }
          ?>
        </ul>
      </div>
      <?php
    } ?>
  </aside>
</div>
<script src="<?php echo BASE_URL ?>scripts/siema.min.js"></script>
<script>
  (function () {
    var containerEl = document.getElementById("home-carousel");
    var prevEl = containerEl.getElementsByClassName("prev")[0];
    var nextEl = containerEl.getElementsByClassName("next")[0];
    var dotsEl = containerEl.getElementsByClassName("dot");
    var onChange = function () {
      for (var i = 0, l = dotsEl.length; i < l; i++) {
        dotsEl[i].classList.toggle("current-dot", this.currentSlide == i);
      }
    }
    var nextSlideInterval = null;
    var carousel = new Siema({
      selector: '.carousel',
      duration: 5,
      loop: true,
      onChange: onChange
    });
    nextSlideInterval = setInterval(function () {
      carousel.next()
    }, 5000);
    prevEl.addEventListener("click", function () {
      carousel.prev(1, onChange);
    });
    nextEl.addEventListener("click", function () {
      carousel.next(1, onChange);
    });
    on('#home-carousel', 'click', '.dot', function (e) {
      carousel.goTo(e.target.getAttribute("data-slide-id"));
      onChange.call(carousel);
    });
  })();
</script>