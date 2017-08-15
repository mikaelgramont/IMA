<?php
require_once __DIR__.'/../php/config.php';
$currentPageId = PageHelper::getCurrentPageId($_SERVER['REQUEST_URI']);
$pageInfo = PageHelper::getPageInfo(Pages::getList(), $currentPageId);
?>
<html>
	<head>

	</head>
	<body>
		<div class="wrapper">
			<header>
				<ul role="nav" class="navigation-menu">
				</ul>
				<a aria-hidden="true" class="banner" href="<?php echo BASE_URL ?>">
				</a>
			</header>
			<main role="main" class="main">
				<section>
<?php echo PageHelper::getPageContent($pageInfo); ?>
				</section>
			</main>
		</div>
	</body>
</html>