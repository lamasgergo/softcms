<?php
include_once dirname(__FILE__).'/Settings.php';

class LanguageService{
    private static $instance;
    protected $languages = array();
    protected $table = 'lang';
    private $db;

    public function __construct(){
        $this->db = ObjectRegistry::getInstance()->get('db');
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
        $query = $this->db->prepare("SELECT `Name`, `Value` FROM ".Settings::get('database_prefix').$this->table);
        $res = $this->db->Execute($query);
        if ($res && $res->RecordCount() > 0){
            while (!$res->EOF){
                $this->languages[$res->fields['Name']] = $res->fields['Value'];
                $res->MoveNext();
            }
        }
    }

    public function getAll(){
        return $this->languages;
    }
}
