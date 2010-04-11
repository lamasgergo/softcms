<?php

require_once (dirname(__FILE__)."/../../classes/tabelement.php");
require_once (dirname(__FILE__)."/baseitems.php");

class BaseCategories extends TabElement {

    protected $type = 'article';

    protected $fields = array('ID', 'UserID', 'Type', 'ParentID', 'Lang', 'Name', 'Description', 'Published', 'LoginRequired');

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
        $query = "SELECT * FROM `{$this->table}` WHERE ParentID='{$parent_id}' AND Lang='{$this->language}' ORDER BY ID";
        $rs = $this->db->Execute($query);
        if ($rs && $rs->RecordCount() > 0) {
            while (!$rs->EOF) {
                $depth_str = '';
                for ($i = 0; $i < $depth; $i++) $depth_str .= '-';
                $ret[] = $rs->fields;
                $ret = $this->getTreeValues($rs->fields["ID"], $ret, $depth);
                $rs->MoveNext();
            }
        }
        return $ret;
    }

    /* show module items*/
    function getValue() {
        $this->smarty->assign("items_arr", $this->getTreeValues());
        return $this->smarty->fetch($this->templatePath . '/table.tpl', null, $this->language);
    }


    function formData($form, $id = "") {
        //Lang
        #$blocks_sql = "SELECT ID, Description FROM ".DB_PREFIX."lang";
        #$this->getOptions($blocks_sql,array('ID','Description'), array('lang_ids','lang_names'));

        // ParentID
        $parent_arr = $this->getTreeListByParent(0);
        $parent_ids = array();
        $parent_names = array();
        foreach ($parent_arr as $parent) {
            $parent_ids[] = $parent["id"];
            $parent_names[] = $parent["name"];
        }
        $this->smarty->assign("parent_ids", $parent_ids);
        $this->smarty->assign("parent_names", $parent_names);

        if (!empty($id)) {
            $query = $this->db->Prepare("SELECT * FROM `{$this->table}` WHERE ID='{$id}'");
            $rs = $this->db->Execute($query);
            if ($rs && $rs->RecordCount() > 0) {

                $values = $rs->GetArray();
                $this->smarty->assign("items_arr", $values);

            } else $this->smarty->assign("items_arr", array());
        } else {
            $this->smarty->assign("items_arr", array());
            $this->smarty->assign("after_checked", "checked");
        }
    }

    function showForm($form, $id = "") {
        $file = '';
        
        if (Access::check($this->moduleName, $form)) {
            $this->formData($form, $id);
            $this->smarty->assign("required", implode(",", $this->requiredFields));
            $this->smarty->assign("form", $form);
            $this->setTemplateVars();
            $file = $this->smarty->fetch($this->templatePath . '/form.tpl', null, $this->language);
        }
        return $file;
    }

    function add($data) {
        $result = true;
        if ($this->checkRequiredFields($data)) {
            if (parent::add($data)) {
                $msg = Locale::get($this->getName() . "_add_suc");
            } else {
                $msg = Locale::get($this->getName() . "_add_err");
                $result = false;
            }
        } else {
            $msg = Locale::get("requered_data_absent");
            $result = false;
        }
        return array($result, $msg);
    }

    function change($data) {
        $result = true;
        if ($this->checkRequiredFields($data)) {
            if (parent::change($data)) {
                $msg = Locale::get($this->getName() . "_change_suc");
            } else {
                $result = false;
                $msg = Locale::get($this->getName() . "_change_err");
            }
        } else {
            $result = false;
            $msg = Locale::get("requered_data_absent");
        }

        return array($result, $msg);
    }

    function delete($data) {
        $ids = parent::delete($data, true);
        if (count($ids) > 0) {
            $msg = Locale::get($this->getName() . "_delete_suc");
            $items = new BaseItems($this->moduleName);
            $items->delete($ids);
            $result = true;
        } else {
            $msg = Locale::get($this->getName() . "_delete_err");
            $result = false;
        }

        return array($result, $msg);
    }


}

?>