<?php
include_once dirname(__FILE__).'/Configuration.php';

class Settings extends Configuration{
    private static $instance;
    protected static $settings = array();
    private $db;

    public function __construct(){
        $this->db = ObjectRegistry::getInstance()->get('db');
        self::$settings = Configuration::$settings;
        $this->load();
    }

    public static function getInstance(){
        if (!isset(self::$instance)){
            $class = __CLASS__;
            return self::$instance = new $class();
        }
        return self::$instance;
    }

    public function load(){
        $query = $this->db->prepare("SELECT `Key`, `Value` FROM ".Configuration::get('database_prefix')."settings");
        $res = $this->db->Execute($query);
        if ($res && $res->RecordCount() > 0){
            while (!$res->EOF){
                self::$settings[$res->fields['Key']] = $res->fields['Value'];
                $res->MoveNext();
            }
        }
    }

    public static  function get($key){
        Settings::getInstance();
        if (isset(self::$settings[$key])) return self::$settings[$key];
    }

    public static  function set($key, $value){
        Settings::getInstance();
        self::$settings[$key] = $value;
    }
}
