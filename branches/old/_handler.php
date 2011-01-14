<?php
$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__));

include_once($_SERVER['DOCUMENT_ROOT']."/config/config.php");
include_once(__PATH__."/init.php");

$path = ModRewrite::clearPath($_SERVER['REQUEST_URI']);

$languages = $langService->getLanguages();

if (in_array($path[0], $languages)){
	$lang = array_shift($path);
	$langService->setLanguage($lang);
}

$path = ModRewrite::checkMenuUrl($path, $lang);

if ($path[count($path)-2]=='page'){
	$page = array_pop($path);
	$_GET[array_pop($path)] = $page;
}

if (count($path)>0){
	$_GET[MODULE] = array_shift($path);
	$_GET['static_path'] = implode("/", $path);
	
	while(count($path)>0){
		$_GET[array_shift($path)] = array_shift($path);
	}
}
require_once('./index.php');
?>