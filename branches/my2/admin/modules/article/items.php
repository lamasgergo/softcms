<?php

require_once (dirname(__FILE__)."/../../classes/tabelement.php");
require_once (dirname(__FILE__) . "/categories.php");

class Items extends TabElement {
    
    protected $type = 'article';

    protected $fields = array('ID', 'Type', 'UserID', 'CategoryID', 'Lang', 'Title', 'Content', 'Teaser', 'Published', 'MetaAlt', 'MetaKeywords', 'MetaTitle', 'MetaDescription', 'LoginRequired', 'ViewCount', 'ImageGroupID', 'Url');

    protected $gridFields = array('ID', 'Type', 'UserID', 'CategoryID', 'Lang', 'Title', 'Published', 'LoginRequired', 'ViewCount', 'Url');

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
	

    function getTabContent() {
//        $this->smarty->assign("items_arr", $this->getValue());
        $this->smarty->assign("classObj", $this);
        return $this->smarty->fetch($this->tableTemplate, null, $this->language);
    }

    function prepareFormData($id=""){
        // ParentID
        $categories = new Categories();
        $categories->setType($this->type);
        $parent_arr = $categories->getTreeListByParent(0);
        $cats = array();
        foreach ($parent_arr as $parent){
        	$cats[$parent["id"]] = $parent["name"];
        }
        $this->smarty->assign("categories", $cats);


	}
	
    function prepareData($data){
        $data['LoginRequired'] = isset($data['LoginRequired']) ? (int)$data['LoginRequired'] : 0;
//        $data['ViewCount'] = (int)$data['LoginRequired'];
        if (!isset($data['Url']) || empty($data['Url'])) $data['Url'] = Translit::makeUrl($data['Title']);
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
        $ids = parent::delete($data);
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