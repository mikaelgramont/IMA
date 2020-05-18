<?php
if (function_exists('xdebug_disable')) {
  xdebug_disable();
}
ini_set('xdebug.default_enable', false);
ini_set('xdebug.html_errors', false);

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
  <script>
    /*! instant.page v5.0.1 - (C) 2019-2020 Alexandre Dieulot - https://instant.page/license */
    let t,e;const n=new Set,o=document.createElement("link"),i=o.relList&&o.relList.supports&&o.relList.supports("prefetch")&&window.IntersectionObserver&&"isIntersecting"in IntersectionObserverEntry.prototype,s="instantAllowQueryString"in document.body.dataset,a="instantAllowExternalLinks"in document.body.dataset,r="instantWhitelist"in document.body.dataset,c=!("instantNoMousedownShortcut"in document.body.dataset),d=1111;let l=65,u=!1,f=!1,m=!1;if("instantIntensity"in document.body.dataset){const t=document.body.dataset.instantIntensity;if("mousedown"==t.substr(0,"mousedown".length))u=!0,"mousedown-only"==t&&(f=!0);else if("viewport"==t.substr(0,"viewport".length))navigator.connection&&(navigator.connection.saveData||navigator.connection.effectiveType&&navigator.connection.effectiveType.includes("2g"))||("viewport"==t?document.documentElement.clientWidth*document.documentElement.clientHeight<45e4&&(m=!0):"viewport-all"==t&&(m=!0));else{const e=parseInt(t);isNaN(e)||(l=e)}}if(i){const n={capture:!0,passive:!0};if(f||document.addEventListener("touchstart",function(t){e=performance.now();const n=t.target.closest("a");if(!h(n))return;v(n.href)},n),u?c||document.addEventListener("mousedown",function(t){const e=t.target.closest("a");if(!h(e))return;v(e.href)},n):document.addEventListener("mouseover",function(n){if(performance.now()-e<d)return;const o=n.target.closest("a");if(!h(o))return;o.addEventListener("mouseout",p,{passive:!0}),t=setTimeout(()=>{v(o.href),t=void 0},l)},n),c&&document.addEventListener("mousedown",function(t){if(performance.now()-e<d)return;const n=t.target.closest("a");if(t.which>1||t.metaKey||t.ctrlKey)return;if(!n)return;n.addEventListener("click",function(t){1337!=t.detail&&t.preventDefault()},{capture:!0,passive:!1,once:!0});const o=new MouseEvent("click",{view:window,bubbles:!0,cancelable:!1,detail:1337});n.dispatchEvent(o)},n),m){let t;(t=window.requestIdleCallback?t=>{requestIdleCallback(t,{timeout:1500})}:t=>{t()})(()=>{const t=new IntersectionObserver(e=>{e.forEach(e=>{if(e.isIntersecting){const n=e.target;t.unobserve(n),v(n.href)}})});document.querySelectorAll("a").forEach(e=>{h(e)&&t.observe(e)})})}}function p(e){e.relatedTarget&&e.target.closest("a")==e.relatedTarget.closest("a")||t&&(clearTimeout(t),t=void 0)}function h(t){if(t&&t.href&&(!r||"instant"in t.dataset)&&(a||t.origin==location.origin||"instant"in t.dataset)&&["http:","https:"].includes(t.protocol)&&("http:"!=t.protocol||"https:"!=location.protocol)&&(s||!t.search||"instant"in t.dataset)&&!(t.hash&&t.pathname+t.search==location.pathname+location.search||"noInstant"in t.dataset))return!0}function v(t){if(n.has(t))return;const e=document.createElement("link");e.rel="prefetch",e.href=t,document.head.appendChild(e),n.add(t)}
  </script>
	</body>
</html>
<?php
}
?>