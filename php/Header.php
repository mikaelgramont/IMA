<?php
class Header
{
	public static function menuContent($items, $currentUrl) {
		$output = '';
		foreach ($items as $item) {
			if (property_exists($item, 'skipMenuEntry') &&  $item->skipMenuEntry) {
				continue;
			}
			$label = ucfirst($item->title);
			if (empty($label)) {
				continue;
			}
			$url = BASE_URL . $item->url;
			$classes = array('navigation-menu__entry');
			if($currentUrl == $item->url) {
				$classes[] = 'selected';
			}
			if (property_exists($item, 'headerClass') &&  $item->headerClass) {
				$classes[] = $item->headerClass;
			}
			$class = implode(" ", $classes);
			
			$output .= <<<HTML
				<li class="{$class}">
					<a href="{$url}" class="navigation-menu__entry-link">
						<span class="navigation-menu__entry-image"></span>
						<span class="navigation-menu__entry-label">{$label}</span>
					</a>
				</li>

HTML;
		}
		return $output;
	}

}
