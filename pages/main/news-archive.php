<?php
$newsItems = PageHelper::getNewsArticlesHTML();
$news = '<ul class="news">' . implode("\n", $newsItems) . '</ul>';
?>

<style>
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
</style>

<?php echo $news; ?>