<?php

require_once (dirname(__FILE__)."/../../classes/tabelement.php");
require_once (dirname(__FILE__)."/basecategories.php");

class BaseItems extends TabElement {
    
    protected $type = 'article';

    protected $fields = array('ID', 'Type', 'UserID', 'CategoryID', 'Lang', 'Title', 'Content', 'Teaser', 'Published', 'MetaAlt', 'MetaKeywords', 'MetaTitle', 'MetaDescription', 'LoginRequired', 'ViewCount', 'ImageGroupID', 'Url');

    protected $requiredFields = array('Title', 'CategoryID');

	function __construct(){

        parent::__construct();
		
		$this->templatePath = dirname(__FILE__).'/templates/items/';
		
		$this->table = DB_PREFIX.'data';
	}
	
	
	function getName(){
		return strtolower(__CLASS__);                    
	}
	
	//set common template vars
	function setTemplateVars() {
        $this->smarty->assign("module", $this->moduleName);
        $this->smarty->assign("component", $this->getName());
    }
	
	function getTabContent(){
		return $this->getValue();	
	}
	
	
	/* show module items*/
	function getValue(){
	    $query = $this->db->Prepare("SELECT * FROM `{$this->table}` WHERE Lang='{$this->language}' ORDER BY ID ASC");
	    $rs = $this->db->Execute($query);
	    if ($rs && $rs->RecordCount() > 0){
	        $this->smarty->assign("items_arr", $rs->GetArray());
	    } else { 
	        $this->smarty->assign("items_arr", array());
	    }
	    return $this->smarty->fetch($this->templatePath.'/table.tpl', null, $this->language);
	}	
	
    function formData($form,$id=""){
        // ParentID
        $categories = new BaseCategories($this->moduleName);
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
			$query = $this->db->Prepare("SELECT * FROM `{$this->table}` WHERE ID='{$id}'");
			$rs = $this->db->Execute($query);
			if ($rs && $rs->RecordCount() > 0){
				
				$values = $rs->GetArray();
				$this->smarty->assign("items_arr",$values);
				
			} else $this->smarty->assign("items_arr",array());
		} else {
			$this->smarty->assign("items_arr",array());
			$this->smarty->assign("after_checked","checked");
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

    function prepareData($data){
        $data['LoginRequired'] = (int)$data['LoginRequired'];
        $data['ViewCount'] = (int)$data['LoginRequired'];
        $data['ImageGroupID'] = (int)$data['ImageGroupID'];
        if (!isset($data['Url']) || empty($data['Url'])) $data['Url'] = Translit::encode($data['Title']);
        return parent::prepareData($data);
    }

    function add($data) {
        $result = true;
        if ($this->checkRequiredFields($data)) {
            if (parent::add($data)) {
                $msg = Locale::get($this->getName() . "_add_suc");
            } else {
                $msg =Locale::get($this->getName() . "_add_err");
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
        $ids = parent::delete($data);
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