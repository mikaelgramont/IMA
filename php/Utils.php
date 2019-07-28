<?php

class Utils
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

  public static function escape($data)
  {
    if (!is_array($data)) {
      $return = htmlentities($data, ENT_QUOTES, 'UTF-8');
    } else {
      $return = array();
      foreach ($data as $key => $value) {
        $return[$key] = self::escape($value);
      }
    }
    return $return;
  }

  public static function removeAccents($string)
  {
    $array = array('&Agrave;', '&Aacute;', '&Acirc;', '&Atilde;', '&Auml;', '&Aring;', '&agrave;', '&aacute;',
      '&acirc;', '&atilde;', '&auml;', '&aring;', '&Ograve;', '&Oacute;', '&Ocirc;', '&Otilde;',
      '&Ouml;', '&Oslash;', '&ograve;', '&oacute;', '&ocirc;', '&otilde;', '&ouml;', '&oslash;',
      '&Egrave;', '&Eacute;', '&Ecirc;', '&Euml;', '&egrave;', '&eacute;', '&ecirc;', '&euml;',
      '&Ccedil;', '&ccedil;', '&Igrave;', '&Iacute;', '&Icirc;', '&Iuml;', '&igrave;', '&iacute;',
      '&icirc;', '&iuml;', '&Ugrave;', '&Uacute;', '&Ucirc;', '&Uuml;', '&ugrave;', '&uacute;',
      '&ucirc;', '&uuml;', '&yuml;', '&Ntilde;', '&ntilde;');
    $replace = array('a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
      'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'c', 'c', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'u', 'u', 'u', 'u', 'u', 'u',
      'u', 'u', 'y', 'n', 'n');
    $return = htmlentities($string, ENT_NOQUOTES, 'UTF-8');
    $return = str_replace($array, $replace, $return);
    $return = html_entity_decode($return, ENT_NOQUOTES, 'UTF-8');
    return $return;
  }

  public static function cleanString($string, $cleanSpace = true)
  {
    $clean = self::removeAccents($string);
    $from = "<>\n\r";
    $to = "------";

    if ($cleanSpace) {
      $from .= ' ';
      $to .= '-';
    }

    $from .= "²&~\"#'{([|`_\\^@)]°=+}¨\$£¤%*?,.;/:!§€…";
    $to .= "--------------------------------------e-";

    $clean = strtr($clean, $from, $to);
    $clean = preg_replace("/(-){2,}/", "-", $clean);
    $clean = trim($clean, ' -');
    return $clean;
  }

  /**
   * Create a url-safe string based on the input
   *
   * @param string $string
   * @return string
   */
  public static function cleanStringForUrl($string)
  {
    $clean = self::escape($string);
    $clean = self::cleanString($clean);
    $clean = strtolower($clean);
    return $clean;
  }

  public static function getFlagFileForCountry($country)
  {
    $countryCode = strtolower(self::getCountryCode($country));
    if (!$countryCode) {
      return "";
    }
    return BASE_URL . "images/flags/" . $countryCode . ".svg";
  }

  public static function getCountryCode($country = '')
  {
    // Return if country isn't defined
    if (!$country) {
      return "";
    }

    // Array of country codes
    $countryCodes = array(
      'af' => 'afghanistan',
      'ax' => 'åland islands',
      'al' => 'albania',
      'dz' => 'algeria',
      'as' => 'american samoa',
      'ad' => 'andorra',
      'ao' => 'angola',
      'ai' => 'anguilla',
      'aq' => 'antarctica',
      'ag' => 'antigua and barbuda',
      'ar' => 'argentina',
      'au' => 'australia',
      'at' => 'austria',
      'az' => 'azerbaijan',
      'bs' => 'bahamas',
      'bh' => 'bahrain',
      'bd' => 'bangladesh',
      'bb' => 'barbados',
      'by' => 'belarus',
      'be' => 'belgium',
      'bz' => 'belize',
      'bj' => 'benin',
      'bm' => 'bermuda',
      'bt' => 'bhutan',
      'bo' => 'bolivia',
      'ba' => 'bosnia and herzegovina',
      'bw' => 'botswana',
      'bv' => 'bouvet island',
      'br' => 'brazil',
      'io' => 'british indian ocean territory',
      'bn' => 'brunei darussalam',
      'bg' => 'bulgaria',
      'bf' => 'burkina faso',
      'bi' => 'burundi',
      'kh' => 'cambodia',
      'cm' => 'cameroon',
      'ca' => 'canada',
      'cv' => 'cape verde',
      'ky' => 'cayman islands',
      'cf' => 'central african republic',
      'td' => 'chad',
      'cl' => 'chile',
      'cn' => 'china',
      'cx' => 'christmas island',
      'cc' => 'cocos (keeling) islands',
      'co' => 'colombia',
      'km' => 'comoros',
      'cg' => 'congo',
      'cd' => 'zaire',
      'ck' => 'cook islands',
      'cr' => 'costa rica',
      'ci' => 'côte d\'ivoire',
      'hr' => 'croatia',
      'cu' => 'cuba',
      'cy' => 'cyprus',
      'cz' => 'czech republic',
      'dk' => 'denmark',
      'dj' => 'djibouti',
      'dm' => 'dominica',
      'do' => 'dominican republic',
      'ec' => 'ecuador',
      'eg' => 'egypt',
      'sv' => 'el salvador',
      'gq' => 'equatorial guinea',
      'er' => 'eritrea',
      'ee' => 'estonia',
      'et' => 'ethiopia',
      'fk' => 'falkland islands (malvinas)',
      'fo' => 'faroe islands',
      'fj' => 'fiji',
      'fi' => 'finland',
      'fr' => 'france',
      'gf' => 'french guiana',
      'pf' => 'french polynesia',
      'tf' => 'french southern territories',
      'ga' => 'gabon',
      'gm' => 'gambia',
      'ge' => 'georgia',
      'de' => 'germany',
      'gh' => 'ghana',
      'gi' => 'gibraltar',
      'gr' => 'greece',
      'gl' => 'greenland',
      'gd' => 'grenada',
      'gp' => 'guadeloupe',
      'gu' => 'guam',
      'gt' => 'guatemala',
      'gg' => 'guernsey',
      'gn' => 'guinea',
      'gw' => 'guinea-bissau',
      'gy' => 'guyana',
      'ht' => 'haiti',
      'hm' => 'heard island and mcdonald islands',
      'va' => 'vatican city state',
      'hn' => 'honduras',
      'hk' => 'hong kong',
      'hu' => 'hungary',
      'is' => 'iceland',
      'in' => 'india',
      'id' => 'indonesia',
      'ir' => 'iran, islamic republic of',
      'iq' => 'iraq',
      'ie' => 'ireland',
      'im' => 'isle of man',
      'il' => 'israel',
      'it' => 'italy',
      'jm' => 'jamaica',
      'jp' => 'japan',
      'je' => 'jersey',
      'jo' => 'jordan',
      'kz' => 'kazakhstan',
      'ke' => 'kenya',
      'ki' => 'kiribati',
      'kp' => 'korea, democratic people\'s republic of',
      'kr' => 'korea, republic of',
      'kw' => 'kuwait',
      'kg' => 'kyrgyzstan',
      'la' => 'lao people\'s democratic republic',
      'lv' => 'latvia',
      'lb' => 'lebanon',
      'ls' => 'lesotho',
      'lr' => 'liberia',
      'ly' => 'libyan arab jamahiriya',
      'li' => 'liechtenstein',
      'lt' => 'lithuania',
      'lu' => 'luxembourg',
      'mo' => 'macao',
      'mk' => 'macedonia, the former yugoslav republic of',
      'mg' => 'madagascar',
      'mw' => 'malawi',
      'my' => 'malaysia',
      'mv' => 'maldives',
      'ml' => 'mali',
      'mt' => 'malta',
      'mh' => 'marshall islands',
      'mq' => 'martinique',
      'mr' => 'mauritania',
      'mu' => 'mauritius',
      'yt' => 'mayotte',
      'mx' => 'mexico',
      'fm' => 'micronesia, federated states of',
      'md' => 'moldova, republic of',
      'mc' => 'monaco',
      'mn' => 'mongolia',
      'me' => 'montenegro',
      'ms' => 'montserrat',
      'ma' => 'morocco',
      'mz' => 'mozambique',
      'mm' => 'myanmar',
      'na' => 'namibia',
      'nr' => 'nauru',
      'np' => 'nepal',
      'nl' => 'netherlands',
      'an' => 'netherlands antilles',
      'nc' => 'new caledonia',
      'nz' => 'new zealand',
      'ni' => 'nicaragua',
      'ne' => 'niger',
      'ng' => 'nigeria',
      'nu' => 'niue',
      'nf' => 'norfolk island',
      'mp' => 'northern mariana islands',
      'no' => 'norway',
      'om' => 'oman',
      'pk' => 'pakistan',
      'pw' => 'palau',
      'ps' => 'palestinian territory, occupied',
      'pa' => 'panama',
      'pg' => 'papua new guinea',
      'py' => 'paraguay',
      'pe' => 'peru',
      'ph' => 'philippines',
      'pn' => 'pitcairn',
      'pl' => 'poland',
      'pt' => 'portugal',
      'pr' => 'puerto rico',
      'qa' => 'qatar',
      're' => 'réunion',
      'ro' => 'romania',
      'ru' => 'russia',
      'rw' => 'rwanda',
      'sh' => 'saint helena',
      'kn' => 'saint kitts and nevis',
      'lc' => 'saint lucia',
      'pm' => 'saint pierre and miquelon',
      'vc' => 'saint vincent and the grenadines',
      'ws' => 'samoa',
      'sm' => 'san marino',
      'st' => 'sao tome and principe',
      'sa' => 'saudi arabia',
      'sn' => 'senegal',
      'rs' => 'serbia',
      'sc' => 'seychelles',
      'sl' => 'sierra leone',
      'sg' => 'singapore',
      'sk' => 'slovakia',
      'si' => 'slovenia',
      'sb' => 'solomon islands',
      'so' => 'somalia',
      'za' => 'south africa',
      'gs' => 'south georgia and the south sandwich islands',
      'es' => 'spain',
      'lk' => 'sri lanka',
      'sd' => 'sudan',
      'sr' => 'suriname',
      'sj' => 'svalbard and jan mayen',
      'sz' => 'swaziland',
      'se' => 'sweden',
      'ch' => 'switzerland',
      'sy' => 'syrian arab republic',
      'tw' => 'taiwan, province of china',
      'tj' => 'tajikistan',
      'tz' => 'tanzania, united republic of',
      'th' => 'thailand',
      'tl' => 'timor-leste',
      'tg' => 'togo',
      'tk' => 'tokelau',
      'to' => 'tonga',
      'tt' => 'trinidad and tobago',
      'tn' => 'tunisia',
      'tr' => 'turkey',
      'tm' => 'turkmenistan',
      'tc' => 'turks and caicos islands',
      'tv' => 'tuvalu',
      'ug' => 'uganda',
      'ua' => 'ukraine',
      'ae' => 'united arab emirates',
      'gb' => 'united kingdom',
      'us' => 'united states',
      'um' => 'united states minor outlying islands',
      'uy' => 'uruguay',
      'uz' => 'uzbekistan',
      'vu' => 'vanuatu',
      've' => 'venezuela',
      'vn' => 'viet nam',
      'vg' => 'virgin islands, british',
      'vi' => 'virgin islands, u.s.',
      'wf' => 'wallis and futuna',
      'eh' => 'western sahara',
      'ye' => 'yemen',
      'zm' => 'zambia',
      'zw' => 'zimbabwe',
    );

    foreach ($countryCodes as $code => $name) {
      if ($name == $country) {
        return $code;
      }
    }

    // Other abbreviations for user's sakes:
    switch ($country) {
      case "uk":
        return "gb";
      case "usa":
        return "us";
      case "england":
        return "gb";
    }
    return "";
  }

  public static function getOGMetaFromUrl($url)
  {
    if (strpos($url, "youtube.com") !== false) {
      // Because of course YT can't do normal OG stuff.
      return self::getYouTubeMetaFromUrl($url);
    }

    $obj = new stdClass();
    $obj->title = "";
    $obj->image = "";

    // Set some user agent in order to guarantee scraping is not blocked.
    ini_set('user_agent', 'Mozilla/4.0 (compatible; MSIE 6.0)');
    $page = file_get_contents($url);
    error_log($page);
    $doc = new DOMDocument();
    @$doc->loadHTML($page);
    $title_div = $doc->getElementsByTagName('title')[0];
    if ($title_div) {
      $obj->title = $title_div->nodeValue;
    }

    $metas = $doc->getElementsByTagName('meta');
    foreach ($metas as $meta) {
      if (!$meta->getAttribute('property')) {
        continue;
      }
      if ($meta->getAttribute('property') == "og:title") {
        $obj->title = $meta->getAttribute('content');
        continue;
      }
      if ($meta->getAttribute('property') == "og:image") {
        $obj->image = $meta->getAttribute('content');
        continue;
      }
    }

    //die('<pre>'.var_export($obj, true).'</pre>');
    return $obj;
  }

  /* This is pretty damn fragile. */
  public static function getYouTubeMetaFromUrl($url)
  {
    $obj = new stdClass();

    $page = file_get_contents($url);
    $doc = new DOMDocument();
    $doc->loadHTML($page);
    $title_div = $doc->getElementsByTagName('title')[0];
    $obj->title = $title_div->nodeValue;

    preg_match("/\?v=([a-zA-Z_\-0-9]*)/", $url, $res);
    $obj->image = "https://i.ytimg.com/vi/" . $res[1] . "/hqdefault.jpg";
    return $obj;
  }

  public static function dateToTimestamp($date)
  {
    $parts = date_parse_from_format("m/d/Y", $date);
    $time = mktime(0, 0, 0, $parts['month'], $parts['day'], $parts['year']);
    return $time;
  }

  public static function datetimeToTimestamp($date)
  {
    $parts = date_parse_from_format("m/d/Y H:i:s", $date);
    $time = mktime($parts['hour'], $parts['minute'], $parts['second'], $parts['month'], $parts['day'], $parts['year']);
    return $time;
  }

  public static function getUserLanguages()
  {
    /*
      Array
      (
          [en-ca] => 1
          [en] => 0.8
          [en-us] => 0.6
          [de-de] => 0.4
          [de] => 0.2
      )
     */
    $langs = array();

    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
      // break up string into pieces (languages and q factors)
      preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $lang_parse);

      if (count($lang_parse[1])) {
        // create a list like "en" => 0.8
        $langs = array_combine($lang_parse[1], $lang_parse[4]);

        // set default to 1 for any without q factor
        foreach ($langs as $lang => $val) {
          if ($val === '') $langs[$lang] = 1;
        }

        // sort list based on value
        arsort($langs, SORT_NUMERIC);
      }
    }
    return $langs;
  }

  public static function pickUserLanguageInList($availableLanguages, $defaultLanguage, $queryArg = null) {
    if ($queryArg) {
      $userLanguages = array($queryArg => 1);
    } else {
      $userLanguages = self::getUserLanguages();
    }

    foreach ($userLanguages as $userLanguage => $prefRatio) {
      foreach ($availableLanguages as $availableLanguage) {
        $languageParts = explode('-', $userLanguage);
        $currentUserLanguage = $languageParts[0];
        if (strpos($currentUserLanguage, $availableLanguage) === 0) {
          return $currentUserLanguage;
        }
      }
    }
    return $defaultLanguage;
  }

  public static function getFilesInFolder($folder, $glob) {
    return glob($folder."/".$glob);
  }

  public static function uuidV4($data = null)
  {
    if (!$data) {
      $data = random_bytes(16);
    }

    assert(strlen($data) == 16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
  }

  public static function autoLink($text) {
    $pattern = '/(((http[s]?:\/\/(.+(:.+)?@)?)|(www\.))[a-z0-9](([-a-z0-9]+\.)*\.[a-z]{2,})?\/?[a-z0-9.,_\/~#&=:;%+?-]+)/is';
    $text = preg_replace($pattern, ' <a href="$1">$1</a>', $text);
    // fix URLs without protocols
    $text = preg_replace('/href="www/', 'href="http://www', $text);
    return $text;
  }
}