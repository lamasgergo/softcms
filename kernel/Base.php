<?php
class Base {

    protected $db;
    protected $smarty;
    public $type = __CLASS__;
    public $table;

    protected $primaryKey = 'ID';
    protected $id;

    protected $data;

    public $language;

    public function __construct(){
        global $db, $smarty;

        $this->db = $db;
        $this->smarty = $smarty;
        $this->type = $this->getName();

        $this->language = 'ru';

        $this->templatePath = realpath(dirname(__FILE__)."/../design/{$this->getName()}/");

        $this->table = DB_PREFIX . 'data';
    }

    protected function getName(){
        return strtolower($this->type);
    }

    public function setID($id=''){
        $id = (int)$id;
        if (!empty($id)){
            $this->id = $id;
        }
    }

    public function getDetail($id=''){
        if (empty($id)) $id = $this->id;
        if (empty($id)) return false;
        $id = $this->db->escape($id);
        $query = $this->db->Prepare("SELECT * FROM {$this->table} WHERE `{$this->primaryKey}`='{$id}'");
        $rs = $this->db->Execute($query);
        if ($rs && $rs->RecordCount() > 0){
            $this->data = $rs->fields;
        }
    }

    public function show($template=''){
        if (empty($template)) $template = "index";
        $this->smarty->assignByRef('this', $this);
        $this->smarty->display($this->templatePath."/$template.tpl", null, $this->language);
    }
}
?>