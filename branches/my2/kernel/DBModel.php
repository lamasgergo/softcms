<?php
 
class DBModel{
    protected $db;
    protected $tablePrefix;
    protected $table;
    protected $fieldsOnly = false; //Use only $fields in query
    protected $fields = array();
    protected $joins = array();

    protected $primaryKey = 'ID';
    protected $id;

    public function __construct(){
        $this->tablePrefix = Settings::get('database_prefix');
        $this->db = DB::getInstance();
    }
}
?>