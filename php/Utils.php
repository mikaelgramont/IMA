<?php
class Utils
{
    public static function escape($data)
    {
        if(!is_array($data)){
            $return = htmlentities($data, ENT_QUOTES, 'UTF-8');
        } else {
            $return = array();
            foreach($data as $key=>$value){
                $return[$key] = self::escape($value);
            }
        }
        return $return;
    }

    public static function removeAccents($string)
    {
        $array = array('&Agrave;', '&Aacute;', '&Acirc;', '&Atilde;', '&Auml;', '&Aring;', '&agrave;', '&aacute;',
                       '&acirc;','&atilde;', '&auml;', '&aring;', '&Ograve;', '&Oacute;', '&Ocirc;', '&Otilde;',
                       '&Ouml;', '&Oslash;', '&ograve;', '&oacute;', '&ocirc;', '&otilde;', '&ouml;', '&oslash;',
                       '&Egrave;', '&Eacute;', '&Ecirc;', '&Euml;', '&egrave;', '&eacute;', '&ecirc;', '&euml;',
                       '&Ccedil;', '&ccedil;', '&Igrave;', '&Iacute;', '&Icirc;', '&Iuml;', '&igrave;','&iacute;',
                       '&icirc;', '&iuml;', '&Ugrave;', '&Uacute;', '&Ucirc;', '&Uuml;', '&ugrave;', '&uacute;',
                       '&ucirc;', '&uuml;', '&yuml;', '&Ntilde;', '&ntilde;');
        $replace = array('a','a','a','a','a','a','a','a','a','a','a','a','o','o','o','o','o','o','o','o','o','o','o','o',
                         'e','e','e','e','e','e','e','e','c','c','i','i','i','i','i','i','i','i','u','u','u','u','u','u',
                         'u','u','y','n','n');
        $return = htmlentities($string,ENT_NOQUOTES, 'UTF-8');
        $return = str_replace($array, $replace, $return);
        $return = html_entity_decode($return,ENT_NOQUOTES, 'UTF-8');
        return $return;
    }

    public static function cleanString($string, $cleanSpace = true)
    {
        $clean = self::removeAccents($string);
        $from = "<>\n\r";
        $to   = "------";
        
        if($cleanSpace){
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
}