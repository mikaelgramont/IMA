<?php
class PageHelper
{
    public static function analytics($id)
    {
            $content = <<<HTML
    <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', '{$id}', 'auto');
            ga('send', 'pageview');
    </script>

HTML;
            return $content;
    }

    public static function getPageIdAndParams($baseUrl, $fullUrl)
    {
        $queryUrl = $fullUrl;
        if (substr($queryUrl, 0, strlen($baseUrl)) == $baseUrl) {
            $queryUrl = substr($queryUrl, strlen($baseUrl));
        }

        $parts = explode('?', $queryUrl);
        $path = array_shift($parts);

        $parts = explode('/', $path);

        $id = array_shift($parts);
        $params = $parts;
        
        return array($id, $params);
    }

    public static function getPageInfo($items, $currentUrl)
    {
            $ret = null;
            foreach ($items as $item) {
                    if ($item->url == $currentUrl) {
                        $ret = $item;
                            break;
                    }
            }
            return $ret;
    }

    public static function getFullUrl()
    {
        if (!isset($_SERVER['HTTP_HOST'])) {
            return '';
        }
        return $fullUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    public static function getBaseUrl()
    {
        if (isset($_SERVER['HTTP_HOST'])) {
            $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
            $hostname = $_SERVER['HTTP_HOST'];
            $dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

            $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
            $core = $core[0];

            $tmplt = "%s://%s%s";
            $end = $dir;
            $base_url = sprintf( $tmplt, $http, $hostname, $end );
        } else {
        	$base_url = 'http://localhost/';
        }
        return $base_url;
    }

    public static function getCurrentPageId($path)
    {
		$preg = '/(.*)\/([^?]*)[\?.*]?/i';
		$matches = null;
		preg_match($preg, $path, $matches);
		return sizeof($matches) == 3 ? $matches[2] : '';
    }

    public static function isNewsPage($pageInfo)
    {
        return $pageInfo->url == 'news';   
    }

    public static function pageContentHasImageMeta ($pageInfo)
    {
        if ($pageInfo->url == 'news') {
            return true;
        }

        $file = '../pages/' . $pageInfo->file;
        if (!file_exists($file)) {
            return false;
        }
        $content = file_get_contents($file);
        $parts = explode(NEWS_SEPARATOR, $content);
        $meta = $parts[0];
        return self::metaHasImage($meta);
    }

	public static function getPageContent($pageInfo) {
		if (!$pageInfo) {
			return '';
		}
		ob_start();
	    include '../pages/' . $pageInfo->file;
	    $fileContent = ob_get_contents();
        $parts = explode(NEWS_SEPARATOR, $fileContent);
        // Only keep the last part, in case the file contains metas at the top.
        $content = array_pop($parts);

	    ob_end_clean();
		return $content.PHP_EOL;
	}

    public static function getPageMeta($pageInfo) {
        if (!$pageInfo) {
            return '';
        }
        ob_start();
        include '../pages/' . $pageInfo->file;
        $fileContent = ob_get_contents();
        $parts = explode(NEWS_SEPARATOR, $fileContent);
        // Only keep the last part, in case the file contains metas at the top.
        $content = $parts[0];
        $content = str_replace("\$OG_URL/", OG_URL, $content);

        ob_end_clean();
        return $content.PHP_EOL;
    }   

	public static function getAvailableYears() {
		$years = array();
		$files = scandir(RESULTS_HTML_PATH);
		foreach ($files as $file) {
            $extension = substr($file, -4);
            $name = substr($file, 0, -4);
			if (is_numeric($name) && $extension == ".php") {
				$years[] = $name;
			}
		}
		rsort($years);
		return $years;		
	}

    public static function getNewsArticlesHTML() {
        $news = array();
        $files = array_filter(scandir(NEWS_HTML_PATH), function($item) {
          return !is_dir(NEWS_HTML_PATH.'/' . $item);
        });
        foreach ($files as $file) {
            $newsPage = new NewsPage(BASE_URL, NEWS_SEPARATOR, NEWS_HTML_PATH, $file);
            if (!$newsPage->isStatic()) {
              continue;
            }
            $newsPage->parse(OG_URL);
            $news[$newsPage->getName()] = $newsPage->getHomePageMarkup();
        }
        natsort($news);
        for ($i = 0 ; $i < NEWS_COUNT; $i++) {
          $ret[] = array_pop($news);
        }
        return '<ul class="news">' . implode("\n", $ret) . '</ul>';
    }

    public static function getNewsArticleMeta() {
      $param = PAGE_PARAMS[0];
      $newsPage = new NewsPage(BASE_URL, NEWS_SEPARATOR, NEWS_HTML_PATH,  $param . ".html");
      $newsPage->parse(OG_URL);
      $meta = $newsPage->getMeta();
      return $meta;
    }

    public static function metaHasImage($meta) {
        $key = "og:image";
        return strpos($meta, $key) !== FALSE;
    }
}