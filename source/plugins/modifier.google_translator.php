<?php

require_once dirname(__FILE__).'/../../kernel/googleTranslator.php';

function smarty_modifier_google_translator($string=""){
global $langs;	
	
	$string = trim($string);
	if (empty($string)) return "";
	
	$string = preg_replace("/\<br\s*\/?\>/ui","\r\n",$string);
	$url_string = urlencode($string);
	
	if (isset($langs["$url_string"])){
		return $langs["$url_string"];	
	}
	
	$g = new Google_API_translator();
	$g->setOpts(array("text" => $string, "language_pair" => "en|ru", "hl" => "ru", "ie" => "UTF8"));
	$out_string = $g->translate();
	
	$out_string = preg_replace("/\r\n/u","<br />", $out_string);
	$out_string = preg_replace("/(\-)+/u","-", $out_string);
	
	$out_string = preg_replace("/\r\n/ui","<br />",$out_string);
	
	$langs["$url_string"] = "$out_string";
	
	return $out_string;
}

/*
function smarty_modifier_google_translator($string=""){
	return prompt_translator($string);
}
*/

function prompt_translator($string){
global $langs;
	$string = trim($string);
	if (empty($string)) return "";
	
	$string = preg_replace("/\<br\s*\/?\>/ui","\r\n",$string);
	$url_string = urlencode($string);
	
	if (isset($langs["$url_string"])){
		return $langs["$url_string"];	
	}

	$url = "http://wap.translate.ru/wap2/translator.aspx/result/?tbDirection=er&tbText=".$url_string."&Submit=%D0%9F%D0%B5%D1%80%D0%B5%D0%B2%D0%B5%D1%81%D1%82%D0%B8";
	$ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_HTTPGET, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$html = curl_exec($ch);
    if(curl_errno($ch)) $html = "";
    curl_close ($ch);
	preg_match_all('|\<p class\=\"result\"\>([^\<]+)\<\/p\>|U', $html, $out);
    
	$out_string = $out[1][1];
	
	$out_string = preg_replace("/\r\n/ui","<br />",$out_string);
	
	$langs["$url_string"] = "$out_string";
	
	return $out_string;
}

?>