<?php

echo "This is the 5-2018-wmc php page.";

$pool = Cache::getPool();
$allPhotos = array();

$IMAScraper = new Instagram(INSTAGRAM_USERNAME, $pool, array(), true, 'ima-photos');
$IMAPhotos = $IMAScraper->getPhotos();

$tagScraper = new InstagramTag('skate', $pool, array(), true, 'tag-photos');
$tagPhotos = $tagScraper->getPhotos();


//echo '<pre>';
//foreach($photos as $photo) {
//    echo $photo['id']."\n";
//    echo $photo['thumbnail_src']."\n";
//}
//echo '</pre>';

function renderItem($data) {
    $html = <<<HTML
    <li><img src="{$data['thumbnail_src']}"></li>

HTML;
    return $html;
}


echo '<h1>IMA</h1>';
echo '<ul>';
foreach($photos as $photo) {
    echo renderItem($photo)."\n";
}
echo '</ul>';

echo '<h1>TAG</h1>';
echo '<ul>';
foreach($photos as $photo) {
    echo renderItem($photo)."\n";
}
echo '</ul>';
?>