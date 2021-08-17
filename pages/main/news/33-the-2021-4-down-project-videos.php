<?php
define('VOTING_END_DATE', 'Aug 31st');
define('WINNERS_DATE', 'Sept 1st');
define('PREMIERE_VIDEO_ID', 'oB4zWpcaHYE');
define('VOTING_URL', 'https://docs.google.com/forms/d/e/1FAIpQLScOqz27VjGfO5AdfWyXzhVHXwvkrms_p1iGOJPq9mMj8ueKbw/viewform');

$videos = [
  ['name'=> 'Costa Rica 🇨🇷 - De la Tierra al Cielo', 'videoId' => 'vVgnZDCq-qc', 'athletes' => 'James González Valle, Marco Dixon, Giancarlo Navas, Rolando Chinchilla Dinarte'],
  ['name'=> 'South Africa 🇿🇦 - It\'s All Downhill From Here', 'videoId' => '_hLjHWQhkbo', 'athletes' => 'Quisto van Greunen, Court Gibson, Skollie Skolwani'],
  ['name'=> 'Switzerland 🇨🇭 - From Dust Till Downhill', 'videoId' => '1F9lQBz5-j4', 'athletes' => 'Marco Dahler, Dave Hutter'],
  ['name'=> 'Ukraine 🇺🇦 - Mountain ВЙО!', 'videoId' => 'ba1T6qyavHc', 'athletes' => 'Roman Sauliak, Anton Khimenko, Andrii Kytseliuk'],
];

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
  .yt-video-wrapper {
    margin: 2em auto 3em;
    position: relative;
    padding-top: 56.25%;
    background: #ddd center center no-repeat url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB2aWV3Qm94PSIwIDAgNjAgNjAiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDYwIDYwOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8Zz4NCgk8cGF0aCBmaWxsPSIjZWVlIiBkPSJNNDUuNTYzLDI5LjE3NGwtMjItMTVjLTAuMzA3LTAuMjA4LTAuNzAzLTAuMjMxLTEuMDMxLTAuMDU4QzIyLjIwNSwxNC4yODksMjIsMTQuNjI5LDIyLDE1djMwDQoJCWMwLDAuMzcxLDAuMjA1LDAuNzExLDAuNTMzLDAuODg0QzIyLjY3OSw0NS45NjIsMjIuODQsNDYsMjMsNDZjMC4xOTcsMCwwLjM5NC0wLjA1OSwwLjU2My0wLjE3NGwyMi0xNQ0KCQlDNDUuODM2LDMwLjY0LDQ2LDMwLjMzMSw0NiwzMFM0NS44MzYsMjkuMzYsNDUuNTYzLDI5LjE3NHogTTI0LDQzLjEwN1YxNi44OTNMNDMuMjI1LDMwTDI0LDQzLjEwN3oiLz4NCgk8cGF0aCBmaWxsPSIjZWVlIiBkPSJNMzAsMEMxMy40NTgsMCwwLDEzLjQ1OCwwLDMwczEzLjQ1OCwzMCwzMCwzMHMzMC0xMy40NTgsMzAtMzBTNDYuNTQyLDAsMzAsMHogTTMwLDU4QzE0LjU2MSw1OCwyLDQ1LjQzOSwyLDMwDQoJCVMxNC41NjEsMiwzMCwyczI4LDEyLjU2MSwyOCwyOFM0NS40MzksNTgsMzAsNTh6Ii8+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8L3N2Zz4NCg==');
    background-size: 100px;
  }
  .yt-video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
  }
  .yt-video-caption {
    position: absolute;
    text-align: center;
    width: 100%;
    font-size: .825rem;
  }
  @media screen and (min-width: 640px) {
    .yt-video-wrapper {
      margin: 2em 10px;
    }
  }

  .entries {
    list-style-type: none;
    padding: 0;
  }

  .entries li {
    margin: 0 0 20px;
  }

  .entries iframe {
    display: block;
    width: 352px;
    max-width: calc(100vw - 20px);
    height: 200px;
    margin: 0 auto;
  }

  @media screen and (min-width: 640px) {
    .entries {
      display: flex;
      width: 100%;
      flex-wrap: wrap;
    }
    .entries li {
      width: 50%;
    }
  }

  .entry-title {
    margin: .25em 0 0;
    font-size: 1rem;
    display: block;
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

  .button-container {
    text-align: center;
  }

  .details {
    margin-bottom: 2rem;
  }
  .more {
    display: inline;
  }
  .video-link-small {
    font-size: .825rem;
    max-width: 300px;
    margin: 10px auto;
  }

</style>

<p>
  How time flies! We at the IMA are super excited to present you the entries for the 4th edition of the 4 Down
  Project, our mountainboard video contest!<br>
  Because the World Championships were cancelled again this year, we're holding this online for the second time, and
  even though we don't get to project the premiere at our big annual gathering, we're still together in spirit, so
  sit down, grab a beverage and enjoy this year's videos from <b>Costa Rica, South Africa, Switzerland,
    and Ukraine!</b>
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

<figure class="yt-video-wrapper">
  <iframe class="yt-video" src="https://www.youtube.com/embed/<?php echo PREMIERE_VIDEO_ID ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
  <figcaption class="yt-video-caption">
    Many thanks to Amon Shaw for the editing on this premiere video - again!
  </figcaption>
</figure>
<p class="video-link-small">
  Video not working? <a href="https://youtu.be/<?php echo PREMIERE_VIDEO_ID ?>" target="_blank" rel="noreferrer noopener">Open it on YouTube instead</a>
</p>

<p class="button-container">
  <a class="link-as-button" target="_blank" href="<?php echo VOTING_URL ?>">Vote for your favorite video!</a>
</p>

<p>
  The voting window is open until <b><?php echo VOTING_END_DATE ?></b>, and we'll announce the winners on
  <?php echo WINNERS_DATE?>. Please spread the word, we want the world to watch these videos!
</p>

<details class="details">
  <summary><h2 class="display-font more">More about the contestants and their videos</h2></summary>
  <div>
    <p>
      The contestants for 2021 are:
    </p>

    <ul class="entries">
<?php
  echo implode("\n", array_map(function($video) {
    return <<<HTML
      <li>
        <span class="entry-title">
          ${video['name']}<br>
          ${video['athletes']}
        </span>
        <iframe id="ytplayer-1" type="text/html"
                src="https://www.youtube.com/embed/${video['videoId']}"
                frameborder="0"></iframe>
      </li>
HTML;
}, $videos));
?>
    </ul>

  </div>
</details>