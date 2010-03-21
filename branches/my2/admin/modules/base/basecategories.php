<?php

require_once (dirname(__FILE__)."/baseitems.php");

class BaseCategories extends TabElement {

    /* Name of a Tab Element */
    var $name;

    /* Body of a Tab Element */
    var $value;

    /* Action menu for Tab Element */
    var $menu;

    /* Data Filter for Tab Element */
    var $filter;

    /* Name of a DIV where Tab Element will parsed */
    var $visual_div_name;

    /* Smarty object */
    var $smarty;

    /* Lang array with localization vars */
    var $lang;

    /* Var with lang ID for smarty templates engine */
    var $language;

    /* Main module name */
    var $mod_name;

    /* JS sortable params:
      * false 	: don't sort
      * 'S'		: string sorting
      * 'N'		: numeric sorting
      *
      * example: false,'S','N',false,'S','S'
     */
    var $sort_table_fields;

    var $table;

    var $items;

    var $type = 'article';

    var $fields = array('ID', 'UserID', 'Type', 'ParentID', 'Lang', 'Name', 'Description', 'Published');

    var $requiredFields = array('Name');

    function BaseCategories($mod_name) {
        global $form;
        $this->name = __CLASS__;
        parent::TabElement($mod_name);

        $this->setClassVars();

            // set common module path

            // set template and ajax vars
        $this->setTemplateVars();

        $this->table = DB_PREFIX . 'data_categories';
    }

    function setClassVars() {
        $this->sort_table_fields = "false,'S'";
        $this->tpl_path = dirname(__FILE__).'/templates/categories/';
    }

    function getName() {
        return strtolower(__CLASS__);
    }

    //set common template vars
    function setTemplateVars() {
        $this->smarty->assign("module", $this->mod_name);
        $this->smarty->assign("component", $this->getName());
        $this->smarty->assign("sort_table_fields", $this->sort_table_fields);
    }


    function getTreeValues($parent_id = 0, $ret = array(), $depth = 0) {
        $depth++;
        $sql = "SELECT * FROM " . $this->table . " WHERE ParentID='" . $parent_id . "' AND Lang='" . $this->language . "' ORDER BY ID";
        $res = $this->db->Execute($sql);
        if ($res && $res->RecordCount() > 0) {
            while (!$res->EOF) {
                $depth_str = '';
                for ($i = 0; $i < $depth; $i++) $depth_str .= '-';
                $ret[] = $res->fields;
                $ret = $this->getTreeValues($res->fields["ID"], $ret, $depth);
                $res->MoveNext();
            }
        }
        return $ret;
    }

    /* show module items*/
    function getValue() {
        $this->smarty->assign("items_arr", $this->getTreeValues());
        return $this->smarty->fetch($this->tpl_path . '/table.tpl', null, $this->language);
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
            $sql = $this->db->prepare("SELECT * FROM " . $this->table . " WHERE ID='" . $id . "'");
            $res = $this->db->Execute($sql);
            if ($res && $res->RecordCount() > 0) {

                $values = $res->getArray();
                $this->smarty->assign("items_arr", $values);

            } else $this->smarty->assign("items_arr", array());
        } else {
            $this->smarty->assign("items_arr", array());
            $this->smarty->assign("after_checked", "checked");
        }
    }

    function basecategories_form($form, $id = "") {
        $file = '';
        if (check_rights($form)) {
            $this->formData($form, $id);
            $this->smarty->assign("required", implode(",", $this->requiredFields));
            $this->smarty->assign("form", $form);
            $this->smarty->assign("module", $this->mod_name);
            $this->smarty->assign("component", $this->getName());
            $file = $this->smarty->fetch($this->tpl_path . '/form.tpl', null, $this->language);
        }
        return $file;
    }

//    function prepareData($data){
//        if (!isset($data['Published'])) $data['Published'] = 0;
//        $data['UserID'] = $this->user->id;
//        $data['Type'] = $this->type;
//        $data['Lang'] = $this->language;
//        $values = array();
//        foreach ($this->fields as $item){
//            if ($item=='ID'){
//                if (!empty($data[$item])) $values[$item] = mysql_real_escape_string($data[$item]);
//            } else $values[$item] = mysql_real_escape_string($data[$item]);
//        }
//        return $values;
//    }

    function basecategories_add($data) {
        $result = true;
        if ($this->checkRequiredFields($data)) {
            if ($this->add($data)) {
                $msg = $this->lang[$this->getName() . "_add_suc"];
            } else {
                $msg = $this->lang[$this->getName() . "_add_err"];
                $result = false;
            }
        } else {
            $msg = $this->lang["requered_data_absent"];
            $result = false;
        }
        return array($result, $msg);
    }

    function basecategories_change($data) {
        $result = true;
        if ($this->checkRequiredFields($data)) {
            if ($this->change($data)) {
                $msg = $this->lang[$this->getName() . "_change_suc"];
            } else {
                $result = false;
                $msg = $this->lang[$this->getName() . "_change_err"];
            }
        } else {
            $result = false;
            $msg = $this->lang["requered_data_absent"];
        }

        return array($result, $msg);
    }

    function basecategories_delete($data) {
        $ids = $this->deleteRecursive($data);
        if (count($ids) > 0) {
            $msg = $this->lang[$this->getName() . "_delete_suc"];
            $items = new BaseItems($this->mod_name);
            $items->delete($ids);
            $result = true;
        } else {
            $msg = $this->lang[$this->getName() . "_delete_err"];
            $result = false;
        }

        return array($result, $msg);
    }

    function get_category_row_options($id, $cur_id = 0, $Lang = 0, $userid = '', $depth = 0, $row = array()) {
        $depth ++;
        if ($userid != '' && $userid != 0) {
            $userid_sql = " AND UserID='" . $userid . "' ";
        } else
            $userid_sql = '';
        if ($Lang != 0) {
            $Lang_sql = " AND Lang='" . $Lang . "' ";
        } else
            $Lang_sql = "AND Lang='" . $user->EditLang . "'";
        $sql = $this->db->prepare("SELECT * FROM " . DB_PREFIX . "cnt_category WHERE ParentID='" . $id . "' " . $userid_sql . " AND ID<>'" . $cur_id . "' " . $Lang_sql . " ORDER BY Name ASC");
        $res = $this->db->Execute($sql);
        if ($res && $res->RecordCount() > 0) {
            while (! $res->EOF) {
                $depth_value = "";
                for ($i = 1; $i < $depth; $i ++)
                    $depth_value .= '-';
                $row[] = array($res->fields["ID"], $depth_value, $res->fields["Name"]);
                $row = $this->get_category_row_options($res->fields["ID"], $cur_id, $Lang, $userid, $depth, $row);
                $res->MoveNext();
            }
        }
        return $row;
    }

    function categories_showCategories($Lang, $cur_id = 0) {
        isset($this->lang["select_default_name"]) ? $def_value = $this->lang["select_default_name"] : "select_default_name";
        $options = '<select name="ParentID" id="ParentID">';
        $options .= '<option value="0">' . $def_value . '</option>';
        $objResponse = new xajaxResponse();
        $cat = $this->get_category_row_options(0, $cur_id, 0, $Lang);
        for ($i = 0; $i < count($cat); $i ++) {
            $options .= '<option value="' . $cat[$i][0] . '">' . $cat[$i][1] . $cat[$i][2] . '</option>';
        }
        $options .= '</select>';
        $objResponse->addAssign('ParentIDDiv', 'innerHTML', $options);
        return $objResponse->getXML();
    }
}

?>