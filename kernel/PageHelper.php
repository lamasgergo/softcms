<?php

class PageHelper {

	public static function clearPath($url){
		$url = trim(urldecode($url));

		$url = preg_replace("/^\//","",$url);
        $url = preg_replace("/\/$/","",$url);
		$url = preg_replace("/\/+/","/",$url);

		return $url;
	}

    public static function changeLinkParam($link='', $param='', $value=''){
        if (empty($link)) $link = $_SERVER['REQUEST_URI'];
        $value = urlencode($value);
        $param = urlencode($param);
        if (Settings::get('rewrite_urls')){
            if (strpos($link, $param.'/')){
                $link = preg_replace("/^(.*\/".$param."\/)[^\/]+?(\/?.*)$/ui", "\${1}{$value}\${2}", $link);
            } else {
                $link = $link.$param.'/'.$value.'/';
            }
        } else {
            if (strpos($link, $param.'=')){
                $link = preg_replace("/^(.*".$param."=)[^&]+?(.*)$/ui", "\${1}{$value}\${2}", $link);
            } else {
                if (strpos($link, '?')){
                    $link = $link.'&'.$param.'='.$value;
                } else {
                    $link = $link.'?'.$param.'='.$value;
                }
            }
        }
        return $link;
    }
}

?>
