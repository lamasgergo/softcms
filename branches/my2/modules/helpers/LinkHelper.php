<?php

class LinkHelper {

	function getRequeiredVars(){
		return array('menuId');	
	}
	
	function parseLink($link){
		$link_arr = array();
		$items = split("[\&\?]", $link);
		foreach ($items as $item){
			list($name, $value) = split("=", $item);
			$link_arr[trim($name)] = trim($value); 
		}
		return $link_arr;	
	}
	
	function getLink($link){
		return LinkHelper::getStaticLink($link);
	}
	
	function getStaticLink($link){
		$link = trim($link);
		if ($link=="#") return $link;
		
		if (strpos($link, 'http://')!==false && strpos($link, $_SERVER["HTTP_HOST"])===false ){
			return $link;
		}
		
		if (MOD_REWRITE){
			if (preg_match("/^\/?index\.php.*$/ui", $link)){
				$link = preg_replace("/^\/?index\.php(.*)$/ui", "\\1", $link);
				$link = preg_replace("/^\??".MODULE."\=(.*)$/ui", "\\1", $link);
				$link = "/" . preg_replace("/[\=\&]/ui", "/", $link);
			} else {
				$link = preg_replace("/[\=\&]/ui", "/", $link);
			}
		} 
		/*
		else {
			$link = preg_match("/^\/?([^\/]+)\?(.+)$/", $link, $link_parsed);
			
			$script = $link_parsed[1] ? trim($link_parsed[1]) : "/";	
			$link_params = trim($link_parsed[2]);
			
			
			$link_params_arr = LinkHelper::parseLink($link_params);
			
			$link = $script;
			
			if (count($link_params_arr) > 1){
				$params_arr = array();
				foreach ($link_params_arr as $name=>$value){
					$params_arr[] = $name.'='.$value;
				}
				$link = "/".$link.'?'.join("&",$params_arr).'/';
			}
		}
		*/
		return $link;
	}
}

?>
