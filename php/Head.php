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
		$url = str_replace('http://', 'https://', FULL_URL);
		$base = BASE_URL;
		$defaultImage = OG_IMAGE;
		$additionalOGImageMeta = "";

		if (PageHelper::pageContentHasImageMeta($pageInfo)) {
			if(PageHelper::isNewsPage($pageInfo)) {
				$OGMeta = PageHelper::getNewsArticleMeta();
			} else {
				$OGMeta = PageHelper::getPageMeta($pageInfo);
			}
			if (!PageHelper::metaHasImage($OGMeta)) {
				// OG Image is already part of $OGMeta
				$additionalOGImageMeta = "<meta property=\"og:image\" content=\"{$defaultImage}\"/>";
			}
		} else {
			$title = OG_TITLE;
			$description = OG_DESCRIPTION;
			$additionalOGImageMeta = "<meta property=\"og:image\" content=\"{$defaultImage}\"/>";

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
{$OGMeta}{$additionalOGImageMeta}
        <meta property="og:url" content="{$url}"/>
        <meta property="og:type" content="website"/>
        <meta property="og:site_name" content="{$siteName}"/>
        
        <link rel="apple-touch-icon" sizes="180x180" href="{$base}images/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="{$base}images/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="{$base}images/favicon-16x16.png">
        <link rel="manifest" href="{$base}site.webmanifest">
        <link rel="mask-icon" href="{$base}images/safari-pinned-tab.svg" color="#5bbad5">
        
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#F7F7F7">			

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

        <title>{$fullName}</title>


HTML;

	}	

	private static function css_($css) {
		return <<<HTML
		<link rel="stylesheet" href="{$css}">

HTML;

	}	
}
