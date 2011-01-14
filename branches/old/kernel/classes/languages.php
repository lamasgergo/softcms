<?php


class languages {

    var $_current;

    var $default;

    var $_languages = array();

    var $_languagesList = array();

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

}

$lang = new languages();

?>