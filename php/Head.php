<?php
class Head
{
	public static function content($keywords, $pageInfo, $css)
	{
		$content = self::meta_($keywords);
		$content .= self::title_($pageInfo);
		$content .= self::css_($css);
		return $content;
	}

	private static function meta_($keywords) {
		$content = <<<HTML
			<meta name="Content-Type" content="text/html; charset=utf-8" >
			<meta http-equiv="Accept-CH" content="DPR, Viewport-Width, Width" >
			<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" >
			<meta name="Content-Language" content="en" >
			<meta name="keywords" content="{$keywords}">	

HTML;
		return $content;		
	}

	private static function title_($pageInfo) {
		$name = SITE_NAME;
		$fullName = ($pageInfo && $pageInfo->title) ? ucfirst($pageInfo->title). ' - ' .$name : $name;
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
