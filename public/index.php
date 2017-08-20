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
		<script>
		    function on(elSelector, eventName, selector, fn) {
		        var element = document.querySelector(elSelector);

		        element.addEventListener(eventName, function(event) {
		            var possibleTargets = element.querySelectorAll(selector);
		            var target = event.target;

		            for (var i = 0, l = possibleTargets.length; i < l; i++) {
		                var el = target;
		                var p = possibleTargets[i];

		                while(el && el !== element) {
		                    if (el === p) {
		                        return fn.call(p, event);
		                    }

		                    el = el.parentNode;
		                }
		            }
		        });
		    }
		</script>
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
<?php echo Footer::renderFooter() ?>			
		</div>

	</body>
</html>