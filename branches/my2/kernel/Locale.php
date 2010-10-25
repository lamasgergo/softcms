<?php
require_once($_SERVER['DOCUMENT_ROOT']."/kernel/LocaleFS.php");
require_once($_SERVER['DOCUMENT_ROOT']."/kernel/LocaleDB.php");

class Locale{
    private static $lang;

    private static $instance;
    private static $instanceClass = 'LocaleFS';

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $storage = Settings::get('locale_storage');
            if ($storage=='db'){
                self::$instanceClass = 'LocaleDB';
            }
            self::$instance = new self::$instanceClass();
        }
        return self::$instance;
    }

    public static function setLang($lang){
        self::$lang = $lang;
        self::load();
    }

    public static function get($key, $context='DEFAULT'){
        return self::getInstance()->get($key, $context);
    }

    private static function load(){
        return self::getInstance()->load();
    }

}
