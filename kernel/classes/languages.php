<?php


class languages {

    var $_current;

    var $default;

    var $_languages = array();

    var $_languagesList = array();

    var $locale = array();

    var $localeStorePath = '/shared/locale/';

    var $localeDefaultNames = array('common', 'errors', 'site');

    function languages(){
        global $config;
        $this->default = $config->DEFAULT_LANG;
        $this->_current = $config->DEFAULT_LANG;
        $this->_languages = $config->SUPPORTED_LANGUAGES;
        $this->_languagesList = $config->SUPPORTED_LANGUAGES_LIST;
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
}

$lang = new languages();
$lang->localeDefaults();
?>