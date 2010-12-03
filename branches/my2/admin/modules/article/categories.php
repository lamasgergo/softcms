<?php

require_once (dirname(__FILE__)."/../../classes/tabelement.php");
require_once (dirname(__FILE__) . "/items.php");

class Categories extends TabElement {

    protected $type = 'article';

    protected $fields = array('ID', 'UserID', 'Type', 'ParentID', 'Lang', 'Name', 'Description', 'Published', 'LoginRequired', 'Url');

    protected $gridFields = array('ID', 'UserID', 'Type', 'ParentID', 'Lang', 'Name', 'Description', 'Published', 'LoginRequired', 'Url');

    protected $requiredFields = array('Name');

    function __construct() {
        parent::__construct();

        $this->templatePath = dirname(__FILE__).'/templates/categories/';

        $this->table = DB_PREFIX . 'data_categories';
    }

    function getName() {
        return strtolower(__CLASS__);
    }


    function getTreeValues($parent_id = 0, $ret = array(), $depth = 0) {
        $depth++;
        $wh = $this->getWhere();
        $query = "SELECT `".implode("`,`", $this->gridFields)."` FROM `{$this->table}` {$wh} ORDER BY {$this->orderBy} {$this->orderDest}";
//        echo $query."<br>";
        $rs = $this->db->Execute($query);
        if ($rs && $rs->RecordCount() > 0) {
            while (!$rs->EOF) {
                $ret[] = $rs->fields;
                $ret = $this->getTreeValues($rs->fields["ID"], $ret, $depth);
                $rs->MoveNext();
            }
        }
        return $ret;
    }

    /* show module items*/
//    function getData() {
//        return $this->getTreeValues();
//    }

    function getTabContent() {
//        $this->smarty->assign("items_arr", $this->getValue());
        $this->smarty->assign("classObj", $this);
        return $this->smarty->fetch($this->templatePath . '/table.tpl', null, $this->language);
    }


    function prepareFormData($id = "") {
        //Lang
        #$blocks_sql = "SELECT ID, Description FROM ".DB_PREFIX."lang";
        #$this->getOptions($blocks_sql,array('ID','Description'), array('lang_ids','lang_names'));

        // ParentID
        $parent_arr = $this->getTreeListByParent(0);
        $cats = array();
        foreach ($parent_arr as $parent) {
            $cats[$parent["id"]] = $parent["name"];
        }
        $this->smarty->assign("categories", $cats);
    }


    function getUrlByData($data){
        $url = '';
        if (isset($data['ParentID']) && !empty($data['ParentID'])){
            $query = $this->db->Prepare("SELECT Url FROM `{$this->table}` WHERE ID='{$data['ParentID']}'");
            $rs = $this->db->Execute($query);
            if ($rs && $rs->RecordCount() > 0){
                $url = $rs->fields['Url'];
            }
        }
        $url = Translit::makeUrl($data['Url']);
        $uniq = false;
        $append = 1;
        while (!$uniq){
            $query = $this->db->Prepare("SELECT ID FROM `{$this->table}` WHERE Url='{$url}'");
            $rs = $this->db->Execute($query);
            if ($rs && $rs->RecordCount() > 0){
                $append++;
                $url = $url.$append;
            } else $uniq = true;
        }
        return $url;
    }

    function prepareData($data){
        if (!isset($data['Url']) || empty($data['Url'])){
            $data['Url'] = $data['Name'];
            $data['Url'] = $this->getUrlByData($data);
        }
        return parent::prepareData($data);
    }

    function add($data) {
        $result = true;
        if ($this->checkRequiredFields($data)) {
            if (parent::add($data)) {
                $msg = Locale::get("Added successfully", $this->getName());
            } else {
                $msg = Locale::get("Error adding", $this->getName());
                $result = false;
            }
        } else {
            $msg = Locale::get("Requered data absent");
            $result = false;
        }
        return array($result, $msg);
    }

    function change($data) {
        $result = true;
        if ($this->checkRequiredFields($data)) {
            if (parent::change($data)) {
                $msg = Locale::get("Changed successfully", $this->getName());
            } else {
                $result = false;
                $msg = Locale::get("Error changing", $this->getName());
            }
        } else {
            $result = false;
            $msg = Locale::get("Requered data absent");
        }

        return array($result, $msg);
    }

    function delete($data) {
        $ids = parent::delete($data, true);
        if (count($ids) > 0) {
            $msg = Locale::get("Deleted successfully", $this->getName());
            $items = new Users($this->moduleName);
            $items->delete($ids);
            $result = true;
        } else {
            $msg = Locale::get("Error deleting", $this->getName());
            $result = false;
        }

        return array($result, $msg);
    }


}

?>