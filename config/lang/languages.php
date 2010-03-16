<?php

class Lang{

	var $current_lang = DEFAULT_LANG;

	var $SUPPORTED_LANGUAGES = array(
				'ru',
				'ua',
				'en'
	);
	
	var $SUPPORTED_LANGUAGES_LIST = array(
				'ru' => 'Russian',
				'ua' => 'Ukrainian',
				'en' => 'English'
	);
	
	function getLanguages(){
		return $this->SUPPORTED_LANGUAGES;
	}
	
	function getLanguagesList(){
		return $this->SUPPORTED_LANGUAGES_LIST;
	}
	
	function getLanguageID($lang){
		$i=1;
		foreach ($this->getLanguages() as $name){
			if ($lang==$name) return $i;
			$i++;
		}
		return 1;
	}
	
	function getLanguageById($id){
		$i=1;
		foreach ($this->getLanguages() as $name){
			if ($i==$id) return $name;
			$i++;
		}
		return $this->current_lang;
	}
	
	function checkLanguage($lang){
		if (in_array($lang, $this->SUPPORTED_LANGUAGES)) return true;
		return false;
	}
	
	function setLanguage($lang){
		$lang = trim($lang);
		if ($this->checkLanguage($lang)){
			$this->current_lang = $lang;
		} else {
			$this->current_lang = DEFAULT_LANG;
		}
	}
}

$langService = new Lang();	

?>