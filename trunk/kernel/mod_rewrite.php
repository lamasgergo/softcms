<?php

class ModRewrite{

	function clearPath($url){
		$url = trim(urldecode($url));

		$url = preg_replace("/^\//","",$url);
		$url = preg_replace("/\/\//","/",$url);

		$path = explode('/',$url);
		
		return $path;
	}

	function preparePath($link){
		$link = trim($link);
		
		if (preg_match("/^\/?index\.php.*$/ui", $link)){
				$link = preg_replace("/^\/?index\.php(.*)$/ui", "\\1", $link);
				$link = preg_replace("/^\??".MODULE."\=(.*)$/ui", "\\1", $link);
				$link = preg_replace("/[\=\&]/ui", "/", $link);
		} 
		
		return $link;
	}
	
	function checkMenuUrl($path, $lang=''){
		global $db,$langService;
		$url = implode("/", $path);
		$url = preg_replace("/^\/?(.*?)\/?$/","\\1",$url);
		
		if (empty($url)) return $path;
		
		$sql = $db->prepare("SELECT * FROM ".DB_PREFIX."menutree WHERE LinkAlias RLIKE '\/?".$url."\/?'");
		$sql .= " AND LangID='".$langService->getLanguageID($lang)."'";

		$res = $db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			$url = $res->fields['Link'];
			$url = ModRewrite::preparePath($url);
			$path = explode("/", $url);
			$path[] = 'menuId';
			$path[] = $res->fields['ID'];
		}
		
		return $path;
	}
}

?>