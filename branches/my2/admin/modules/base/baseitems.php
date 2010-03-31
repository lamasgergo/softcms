<?php

require_once (dirname(__FILE__)."/../../common/tabelement.php");
require_once (dirname(__FILE__)."/basecategories.php");

class BaseItems extends TabElement {
    
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

    var $table;

	/* JS sortable params:
	 * false 	: don't sort
	 * 'S'		: string sorting
	 * 'N'		: numeric sorting
	 * 
	 * example: false,'S','N',false,'S','S'
	*/
	var $sort_table_fields;

    var $type = 'article';

    var $fields = array('ID', 'Type', 'UserID', 'CategoryID', 'Lang', 'Title', 'Content', 'Teaser', 'Published', 'MetaAlt', 'MetaKeywords', 'MetaTitle', 'MetaDescription', 'LoginRequired', 'ViewCount', 'ImageGroupID');
	
	function __construct($mod_name){
	    global $form;
		$this->name=__CLASS__;

		parent::__construct($mod_name);
		
		$this->setClassVars();
		
		// set template and ajax vars
		$this->setTemplateVars();
		
		$this->table = DB_PREFIX.'data';
	}
	
    function setClassVars(){
	    $this->sort_table_fields = "false,'S'";
	    $this->tpl_path = dirname(__FILE__).'/templates/items/';
	}
	
	function getName(){
		return strtolower(__CLASS__);                    
	}
	
	//set common template vars
	function setTemplateVars() {
        $this->smarty->assign("module", $this->mod_name);
        $this->smarty->assign("component", $this->getName());
        $this->smarty->assign("sort_table_fields", $this->sort_table_fields);
    }
	
	function getTabContent(){
		return $this->getValue();	
	}
	
	
	/* show module items*/
	function getValue(){
	    $sql = $this->db->prepare("SELECT * FROM ".$this->table." WHERE Lang='".$this->language."' ORDER BY ID ASC");
	    $res = $this->db->Execute($sql);
	    if ($res && $res->RecordCount() > 0){
	        $this->smarty->assign("items_arr", $res->getArray());
	    } else { 
	        $this->smarty->assign("items_arr", array());
	    }
	    return $this->smarty->fetch($this->tpl_path.'/table.tpl', null, $this->language);
	}	
	
    function formData($form,$id=""){
        // ParentID
        $categories = new BaseCategories($this->mod_name);
        $parent_arr = $categories->getTreeListByParent(0);
        $parent_ids = array();
        $parent_names = array();
        foreach ($parent_arr as $parent){
        	$parent_ids[] = $parent["id"];
        	$parent_names[] = $parent["name"];
        }
        $this->smarty->assign("category_ids",$parent_ids);
        $this->smarty->assign("category_names",$parent_names);
	    
		if (!empty($id)){
			$sql = $this->db->prepare("SELECT * FROM " . $this->table . " WHERE ID='".$id."'");
			$res = $this->db->Execute($sql);
			if ($res && $res->RecordCount() > 0){
				
				$values = $res->getArray();
				$this->smarty->assign("items_arr",$values);
				
			} else $this->smarty->assign("items_arr",array());
		} else {
			$this->smarty->assign("items_arr",array());
			$this->smarty->assign("after_checked","checked");
		}
	}
	
    function baseitems_form($form, $id = "") {
        $file = '';
        if (check_rights($form)) {
            $this->formData($form, $id);
            $this->smarty->assign("form", $form);
            $this->smarty->assign("module", $this->mod_name);
            $this->smarty->assign("component", $this->getName());
            $file = $this->smarty->fetch($this->tpl_path . '/form.tpl', null, $this->language);
        }
        return $file;
    }

    function prepareData($data){
        $data['LoginRequired'] = (int)$data['LoginRequired'];
        $data['ViewCount'] = (int)$data['LoginRequired'];
        $data['ImageGroupID'] = (int)$data['ImageGroupID'];
        return parent::prepareData($data);
    }

    function baseitems_add($data) {
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

    function baseitems_change($data) {
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

    function baseitems_delete($data) {
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

    
}
?>