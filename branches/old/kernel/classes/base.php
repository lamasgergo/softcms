<?php

class base {
    var $moduleName;

    var $db;

    var $smarty;

    var $language;

    var $langID;

    var $lang;

    var $data;

    var $dataCount = 0;

    /**
     * @param boolean $dynamic true: output in main block; false: some side block
     * @return void
     */

    function base(){
        global $db, $smarty, $lang, $config;
        
        $this->db = $db;
        $this->smarty = $smarty;

        $this->dynamic = $dynamic;
        $this->lang = $lang;
        $this->language = $lang->getLanguage();
        $this->config = $config;
    }

    function setName($name){
        if (!empty($name)){
            $this->moduleName = $name;
        }
    }

    function setTableData($tableName, $primaryKeyName='ID'){
        $this->_tableName = DB_PREFIX.$tableName;
        $this->_primaryKeyName = $primaryKeyName;
    }

    function setID($id){
        $id=(int)$id;
        if (!empty($id)) $this->id = $id;
    }

    function setPage($id){
        $id=(int)$id;
        if (!empty($id)) $this->page = $id;
    }

    function getData($conditions=''){
        $data = array();
        if (!isset($this->_table) || empty($this->_tableKey)) return $data;

        $this->_table = preg_replace('/^\#/', DB_PREFIX, $this->_table);

        if ($this->id){
            $conditions .= " AND ".$this->_table.".".$this->_tableKey."='".$this->id."'";
        }

        $query = "SELECT * FROM ".$this->_table;
        if ($conditions) $query .= " WHERE 1=1 ".$conditions;

        $query = $this->db->prepare($query);
        $res = $this->db->Execute($query);
        if ($res && $res->RecordCount() > 0){
            $data = $res->getArray();
            if ($this->id) $data = $data[0];
        }

        if (!$this->id){
            $count_query = "SELECT COUNT(*) as cnt FROM ".$this->_table;
            if ($conditions) $count_query .= " WHERE 1=1 ".$conditions;
            $count_query = $this->db->prepare($count_query);
            $res = $this->db->Execute($count_query);
            if ($res && $res->RecordCount() > 0){
                $this->dataCount = $res->fields['cnt'];
            }
        }

        echo "Query: ". $query."<br />";
        echo "Result count: ".$this->dataCount."<br>";

        $this->data = $data;
        return $data;
    }

}
