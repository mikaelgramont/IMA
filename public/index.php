<?php
require_once __DIR__.'/../php/config.php';
$pages = Pages::getList();
$currentPageId = PageHelper::getCurrentPageId($_SERVER['REQUEST_URI']);
$pageInfo = PageHelper::getPageInfo($pages, $currentPageId);
?>
<html>
	<head>
	<link href="https://fonts.googleapis.com/css?family=Pathway+Gothic+One|Raleway:500,700" rel="stylesheet">
<?php echo Head::content(KEYWORDS, $pageInfo, 'css/style.css'); ?>
	</head>
	<body>
		<div class="wrapper">
			<header class="page-header">
				<a class="banner" aria-hidden="true" href="<?php echo BASE_URL ?>"></a>
				<ul role="nav" class="navigation-menu">
<?php echo Header::menuContent($pages, $currentPageId) ?>
				</ul>
			</header>
			<main role="main" class="main">
				<section>
<?php echo PageHelper::getPageContent($pageInfo); ?>
				</section>
			</main>
		</div>
	</body>
</html>