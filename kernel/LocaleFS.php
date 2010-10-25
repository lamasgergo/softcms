<?php

class LocaleFS extends Locale{
    private static $lang;
    private static $locale = array();
    private static $storeRoot = '/locale';

    function __construct(){
        $lang = Settings::get('default_lang');
        $user = ObjectRegistry::getInstance()->get('user');
        if ($user){
            $lang = $user->get('EditLang');
        }
        self::$lang = $lang;
        self::load();
    }

    public static function get($key, $context='DEFAULT'){
        if (isset(self::$locale[$context][$key])) return self::$locale[$context][$key];
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
