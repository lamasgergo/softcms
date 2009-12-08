<?php


class modules extends base{

    var $list = array();
    var $_modulesDir = '/modules';

    function modules(){
        parent::base();

        $this->getList();
    }

    function getList(){
        $query = $this->db->prepare("SELECT Name FROM ".DB_PREFIX."modules WHERE Active='1'");
        $res = $this->db->Execute($query);
        if ($res && $res->RecordCount() > 0){
            while(!$res->EOF){
                $this->list[] = strtolower($res->fields['Name']); 
                $res->MoveNext();
            }
        }        
    }

    function loadModules(){
        foreach ($this->list as $moduleName){
            $moduleClass = $_SERVER['DOCUMENT_ROOT'].$this->_modulesDir.'/'.$moduleName.'/'.$moduleName.'.php';
            if (file_exists($moduleClass)){
                include_once($moduleClass);
            }
        }
    }
}

$modules = new modules();

