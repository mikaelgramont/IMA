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

	public static function getPageContent($pageInfo) {
		if (!$pageInfo) {
			return '';
		}
		ob_start();
	    include '../pages/' . $pageInfo->file;
	    $content = ob_get_contents();
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
        $files = scandir(NEWS_HTML_PATH);
        foreach ($files as $file) {
            $extension = substr($file, -4);
            $name = substr($file, 0, -4);
            if ($extension != ".php") {
                continue;
            }
            $content = file_get_contents(NEWS_HTML_PATH . '/' . $file);
            $parts = explode(NEWS_SEPARATOR, $content);

            $url = BASE_URL . 'news/'.$name;
            $news[$name] = '<li><a class="news-link" href="'.$url.'">' . $parts[1] . '</a></li>';
        }
        krsort($news);

        $ret = array();
        $i = 0;
        foreach($news as $key => $val) {
            if ($i >= NEWS_COUNT) {
                break;
            }
            $ret[] = $val;
            $i++;
        }

        return '<ul class="news">' . implode("\n", $ret) . '</ul>';
    }

    public static function getNewsArticleMeta($pageInfo) {
        $param = PAGE_PARAMS[0];
        // Format: baz-foo-bar;
        $file = NEWS_HTML_PATH . $param . ".php";
        if (!file_exists($file)) {
            $errorMsg = "No news by that name found";
        }
        
        $content = file_get_contents($file);
        $parts = explode(NEWS_SEPARATOR, $content);
        return $parts[0];
    }
}