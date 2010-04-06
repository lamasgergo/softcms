<?php

class Locale{
    private static $lang;
    private static $locale = array();
    private static $storeRoot = '/locale'; 

    function __construct($lang=''){
        if (!$lang) $lang = Settings::get('default_lang');
        $this->setLang($lang);
    }

    public static function setLang($lang){
        self::$lang = $lang;
        self::load();
    }

    public static function get($key){
        if (isset(self::$locale[$key])) return self::$locale[$key];
        return $key;
    }

    private static function load(){

        $DOCUMENT_ROOT = realpath(dirname(__FILE__).'/../');
        $path = $DOCUMENT_ROOT.'/'.self::$storeRoot.'/'.self::$lang.'/';
        
        if (file_exists($path)){
            $dir = dir($path);
            while (false !== ($file = $dir->read())) {
                if ($file != '.' && $file !='..' && preg_match("/.*\.php/",$file)){
                    $lang = array();
                    include_once($path.$file);
                    self::$locale = array_merge(self::$locale, $lang);
                    unset($lang);
                }
            }
            $dir->close();
        }

    }

}
