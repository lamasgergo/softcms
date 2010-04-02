<?php
interface iConfiguration{
    public static  function get($key);
    public static  function set($key, $value);
    public function load();
    public function save();
}

class Configuration implements iConfiguration{

    private static $instance;
    protected static $settings = array();
    private $configFile = '/settings.php';

    public function __construct(){
        $this->load();
    }

    public static function getInstance(){
        if (!isset(self::$instance)){
            $class = __CLASS__;
            return self::$instance = new $class();
        }
        return self::$instance;
    }

    public static function get($key){
        $settings = Configuration::getInstance();
        if (isset(self::$settings[$key])) return self::$settings[$key];
    }

    public static function set($key, $value){
        self::$settings[$key] = $value;
    }

    public function load(){
        $settings = array();
        if (file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$this->configFile)){
            require_once($_SERVER['DOCUMENT_ROOT'].'/'.$this->configFile);
        } else {
            header('Location: /install/');
            exit();
        }
        self::$settings = $settings;
    }

    public function save(){}
}
