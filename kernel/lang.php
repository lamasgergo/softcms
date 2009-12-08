<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/config/lang/languages.php');


/*
if (isset($_POST["lang"]) && !empty($_POST["lang"]) && checkLangByName($_POST["language"])){
	$_SESSION["lang_id"] = getLangByName($_POST["lang"]);
}

if (isset($_GET["lang"]) && !empty($_GET["lang"]) && checkLangByName($_GET["lang"])){
	$_SESSION["lang_id"] = getLangByName($_GET["lang"]);
}
*/

$lang = array();

$language = getLanguage();
$LangID = getLanguageID($language);
loadLangArr($lang,$language);


function checkLanguage($lang){
global $langService;
	if (in_array($lang, $langService->getLanguages())){
		return true;
	} else {
		return false;
	}
}

function checkLangByName($lang){
	return checkLanguage($lang);
}

function getLangByName($lang){
	return getLanguageID($lang);
}


function loadLangArr(&$lang,$language){
	if (file_exists(__PATH__.'/locale/'.$language.'/')){
	  $lang_dir = dir(__PATH__.'/locale/'.$language.'/');
	  while (false !== ($lang_file = $lang_dir->read())) {
	    if ($lang_file != '.' && $lang_file !='..' && preg_match("/.*\.php/",$lang_file)){
	      include_once($lang_dir->path.$lang_file);
	    }
	  }
	  $lang_dir->close();
	}
}

function getLanguage(){
global $langService;
	return $langService->current_lang;
}

function getLanguageName($lang_id){
global $langService;
	$langs = $langService->getLanguages();
	return $langs[$lang_id];
}

function getLanguageID($lang){
global $langService;
	return $langService->getLanguageID($lang);
}

function getLanguageList(){
global $langService;
	return $langService->getLanguages();
}

?>