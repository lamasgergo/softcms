<?php


class languages {

    var $_current;

    var $default;

    var $_languages = array();

    var $_languagesList = array();

    var $locale = array();

    var $localeStorePath = '/shared/locale/';

    var $localeDefaultNames = array('common', 'errors', 'site');
	
	var $db;

    function languages(){
        global $config, $db;
        $this->default = $config->DEFAULT_LANG;
        $this->_current = $config->DEFAULT_LANG;
        $this->_languages = $config->SUPPORTED_LANGUAGES;
        $this->_languagesList = $config->SUPPORTED_LANGUAGES_LIST;
		$this->db = $db;
    }

    function getLanguage(){
        return $this->_current;
    }

    function setLanguage($lang){
        if (in_array($lang, $this->getSupportedLanguages())){
            $this->_current = $lang;
        }
    }

    function getSupportedLanguages(){
        return $this->_languages;
    }

    function getSupportedLangList(){
        return $this->_languagesList;
    }


    function loadLocale($module){
        $path = $_SERVER['DOCUMENT_ROOT'].'/'.$this->localeStorePath.'/'.$this->getLanguage().'/'.$module.'.php';
        if (file_exists($path)){
            include_once($path);
            if (count($this->locale) == 0){
                $this->locale = $lang;
            } else {
                array_push($this->locale, $lang);
            }
            unset($lang);
        }
    }

    function localeDefaults(){
        $this->locale = array();
        foreach ($this->localeDefaultNames as $localeFileName){
            $this->loadLocale($localeFileName);
        }
    }

    function getLocale(){
        return $this->locale;
    }

    function locale($name){
        if (isset($this->locale[$name]) && !empty($this->locale[$name])){
            return $this->locale[$name]; 
        }
        return $name;
    }
	
	function loadBackendLocale(){
		$sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."modules WHERE Active='1' ORDER BY Name ASC");
		$res = $this->db->execute($sql);
		if ($res && $res->RecordCount() > 0){
			while (!$res->EOF){
				$this->loadBackendModuleLocale($res->fields['Name']);
				$res->MoveNext();
			}
		} 
	}
	
	function loadBackendModuleLocale($module){
		$path = $_SERVER['DOCUMENT_ROOT'].'/admin/modules/'.$module.'/locale/'.$this->_current.'.php';
		
		if (file_exists($path)){
			include_once($path);
			$this->locale = array_merge($this->locale, $lang);
			unset($lang);
		}
	}
	
	function translate($str){
		if (isset($this->locale[$str])){
			return $this->locale[$str];
		} else return $str;
	}
}

$lang = new languages();
$lang->localeDefaults();
//if (!is_backend()){
	$lang->loadBackendLocale();
//}
?>