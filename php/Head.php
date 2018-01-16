<?php
class Head
{
	public static function content($keywords, $pageInfo, $css)
	{
		$content = self::meta_($keywords, $pageInfo);
		$content .= self::title_($pageInfo);
		$content .= self::css_($css);
		return $content;
	}

	private static function meta_($keywords, $pageInfo) {
		$siteName = OG_SITE_NAME;
		$url = FULL_URL;
		
		if (PageHelper::isNewsPage($pageInfo)) {
			$OGMeta = PageHelper::getNewsArticleMeta($pageInfo);
			
			if (PageHelper::hasImageMeta($OGMeta)) {
				$additionalOGImageMeta = "";
			} else {
				$image = OG_IMAGE;
				$additionalOGImageMeta = "<meta property=\"og:image\" content=\"{$image}\"/>";
			}
		} else {
			$title = OG_TITLE;
			$description = OG_DESCRIPTION;

			$OGMeta = <<<HTML

				<meta property="og:title" content="{$title}"/>
				<meta property="og:description" content="{$description}"/>

HTML;
		}
		$content = <<<HTML
			<meta name="Content-Type" content="text/html; charset=utf-8" >
			<meta http-equiv="Accept-CH" content="DPR, Viewport-Width, Width" >
			<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" >
			<meta name="Content-Language" content="en" >
			<meta name="keywords" content="{$keywords}">

			{$OGMeta}
			{$additionalOGImageMeta}
			<meta property="og:url" content="{$url}"/>
			<meta property="og:type" content="website"/>
			<meta property="og:site_name" content="{$siteName}"/>

HTML;
		return $content;		
	}

	private static function title_($pageInfo) {

		$name = SITE_NAME;
		if ($pageInfo && $pageInfo->title &&
			(!property_exists($pageInfo, 'skipTitleInHead') || !$pageInfo->skipTitleInHead)) {
			$fullName = ucfirst($pageInfo->title);
		} else {
			$fullName = $name;
		}
		
		return <<<HTML
		<title>
			{$fullName}
		</title>

HTML;

	}	

	private static function css_($css) {
		return <<<HTML
		<link rel="stylesheet" href="{$css}">

HTML;

	}	
}
