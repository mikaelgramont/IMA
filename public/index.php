<?php
require_once __DIR__ . '/../php/config-main.php';
session_start();
$pages = Pages::getList();

list($currentPageId, $params) = PageHelper::getPageIdAndParams(BASE_URL, FULL_URL);
define("PAGE_PARAMS", $params);
$pageInfo = PageHelper::getPageInfo($pages, $currentPageId);
$pageContent = PageHelper::getPageContent($pageInfo);
if (!$pageInfo) {
	throw new Exception("No routing found");
}

$needAuth = property_exists($pageInfo, 'auth') && $pageInfo->auth;
if ($needAuth && !Auth::hasAuth()) {
	header('Location: '. BASE_URL . 'login?redirect-after-login=' . $_SERVER['REQUEST_URI']);
	exit();
}

if (!property_exists($pageInfo, 'noContent') || !$pageInfo->noContent) {
?>
<html>
	<head>
		<link href="https://fonts.googleapis.com/css?family=Pathway+Gothic+One|Raleway:500,700" rel="stylesheet">
<?php echo Head::content(KEYWORDS, $pageInfo, BASE_URL . 'css/style.css'); ?>
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
<?php
}
echo $pageContent;
if (!property_exists($pageInfo, 'noContent') || !$pageInfo->noContent) {
?>
				</section>
			</main>
<?php echo Footer::renderFooter() ?>			
		</div>
<?php echo Utils::analytics(ANALYTICS_ID); ?>
	<div class="modal">
		<button class="modal-close" aria-label="Close">
			<img src="<?php echo BASE_URL ?>images/close.svg" width="16" height="16" alt="">
		</button>
		<div class="modal-wrapper"></div>
	</div>
	<div class="overlay"></div>
	<script>
		(function() {
			var modalEl = document.querySelector('.modal-wrapper');
			function closeModal() {
				document.body.classList.remove('modal-visible');
				modalEl.innerHTML = '';		
			}
			function openModal() {
				document.body.classList.add('modal-visible');
				modalEl.scrollTop = 0;
			}

			on('.wrapper', 'click', '.modal-button', function(e) {
				var buttonEl = e.target;
				var modalContentEl = e.target.parentElement.querySelector('.modal-content');
				modalEl.innerHTML = modalContentEl.innerHTML;
				openModal();
			});
			on('body', 'click', '.modal-close', function(e) {
				closeModal();
			});
			document.body.addEventListener('keyup', function(e) {
				if (e.keyCode == 27)  { //ESC
					closeModal();
				}
			});
		})()
	</script>
	</body>
</html>
<?php
}
?>