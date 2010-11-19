<?php

class Settings{
    private static $settings = array();
    private static $table = 'settings';
    private static $configFile  = '/settings.php';

    public static function load(){
        global $db;
        $query = $db->prepare("SELECT `Name`, `Value` FROM ".self::get('database_prefix').self::$table);
        $res = $db->Execute($query);
        if ($res && $res->RecordCount() > 0){
            while (!$res->EOF){
                self::$settings[$res->fields['Name']] = $res->fields['Value'];
                $res->MoveNext();
            }
        }
        return self::$settings;
    }

    public static function loadFS(){
        $settings = array();
        if (file_exists($_SERVER['DOCUMENT_ROOT'].'/'.self::$configFile)){
            require_once($_SERVER['DOCUMENT_ROOT'].'/'.self::$configFile);
        } else {
            header('Location: /install/');
            exit();
        }
        return self::$settings = $settings;
    }

    public static function get($key){
        if (isset(self::$settings[$key])) return self::$settings[$key];
    }

    public static function set($key, $value){
        self::$settings[$key] = $value;
    }
}
