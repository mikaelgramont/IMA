<?php

class Pages
{
  public static function getList()
  {
    return array(
      (object)[
        'title' => 'Home',
        'url' => '',
        'file' => 'home.php',
        'headerClass' => 'home',
        'skipTitleInHead' => true,
      ],
      (object)[
        'title' => 'Events',
        'url' => 'events',
        'file' => 'events.php',
        'headerClass' => 'calendar',
      ],
      (object)[
        'title' => 'Results',
        'url' => 'results',
        'file' => 'results.php',
        'headerClass' => 'results',
      ],
      (object)[
        'title' => 'Organizers',
        'url' => 'organizers',
        'file' => 'organizers.php',
        'headerClass' => 'organizers',
      ],
      (object)[
        'title' => 'About',
        'url' => 'about',
        'file' => 'about.php',
        'headerClass' => 'about',
      ],
      (object)[
        'title' => 'Admin',
        'url' => 'admin',
        'file' => 'admin.php',
        'skipMenuEntry' => true,
        'auth' => true,
      ],
      (object)[
        'title' => '',
        'url' => 'perform-update',
        'file' => 'perform-update.php',
        'skipMenuEntry' => true,
        'noContent' => true,
        'auth' => true,
      ],
      (object)[
        'title' => '',
        'url' => 'done-updating',
        'file' => 'done-updating.php',
        'skipMenuEntry' => true,
        'auth' => true,
      ],
      (object)[
        'title' => 'News',
        'url' => 'news',
        'file' => 'news.php',
        'skipMenuEntry' => true,
      ],
      (object)[
        'title' => 'Interview',
        'url' => 'interviews',
        'file' => 'interviews.php',
        'skipMenuEntry' => true,
      ],
      (object)[
        'title' => 'Event Registration',
        'url' => 'event-registrations',
        'file' => 'event-registrations.php',
        'skipMenuEntry' => true,
      ],
      (object)[
        'title' => 'Subscribe to the IMA newsletter.',
        'url' => 'newsletter',
        'file' => 'newsletter-subscription.php',
        'skipMenuEntry' => true,
      ],
      (object)[
        'title' => 'IMA newsletter content backlog',
        'url' => 'newsletter-content',
        'file' => 'newsletter-content.php',
        'skipMenuEntry' => true,
        'auth' => true,
      ],
      (object)[
        'title' => 'IMA newsletter content ajax endpoint',
        'url' => 'newsletter-ajax',
        'file' => 'newsletter-ajax.php',
        'skipMenuEntry' => true,
        'noContent' => true,
        'auth' => true,
      ],
      (object)[
        'title' => 'IMA newsletter content ajax endpoint',
        'url' => 'newsletter-entry-update',
        'file' => 'newsletter-entry-update.php',
        'skipMenuEntry' => true,
        'noContent' => true,
        'auth' => true,
      ],
      (object)[
        'title' => 'IMA login page',
        'url' => 'login',
        'file' => 'login.php',
        'skipMenuEntry' => true,
        'noContent' => false,
      ],
      (object)[
        'title' => 'IMA do-login page',
        'url' => 'do-login',
        'file' => 'do-login.php',
        'skipMenuEntry' => true,
        'noContent' => true,
      ],
      (object)[
        'title' => 'IMA do-logout page',
        'url' => 'do-logout',
        'file' => 'do-logout.php',
        'skipMenuEntry' => true,
        'noContent' => true,
        'auth' => true,
      ],
      (object)[
        'title' => 'IMA test page',
        'url' => 'test',
        'file' => 'test.php',
        'skipMenuEntry' => true,
        'noContent' => true,
      ],
      (object)[
        'title' => 'Article',
        'url' => 'articles',
        'file' => 'articles.php',
        'skipMenuEntry' => true,
      ],
      (object)[
        'title' => '2018 Video Contest',
        'url' => '2018-video-contest',
        'file' => '2018-video-contest.php',
        'skipMenuEntry' => true,
        'noContent' => false,
      ],
      (object)[
        'title' => 'IMA results',
        'url' => 'results-embed',
        'file' => 'results.php',
        'skipMenuEntry' => true,
        'noContent' => false,
        'embed' => true,
      ],
      (object)[
        'title' => 'Home',
        'url' => 'paypal-transaction-complete',
        'file' => 'paypal-transaction-complete.php',
        'skipMenuEntry' => true,
        'noContent' => true,
      ],
      (object)[
        'title' => 'Older news articles',
        'url' => 'archive',
        'file' => 'news-archive.php',
        'skipMenuEntry' => true,
      ],
      (object)[
        'title' => 'Privacy policy',
        'url' => 'privacy-policy',
        'file' => 'privacy-policy.php',
        'skipMenuEntry' => true,
      ],
    );
  }
}