<?php

require_once (dirname(__FILE__)."/../../classes/tabelement.php");

class Users extends TabElement {
    
    protected $type = 'users';

    protected $dependsOnType = false;

    protected $fields = array('ID', 'Login', 'Password', 'Lang', 'Group', 'Name', 'Email', 'Published', 'EditLang');

    protected $gridFields = array('ID', 'Login', 'Lang', 'Group', 'Name', 'Familyname', 'Email', 'Published', 'EditLang');

    protected $requiredFields = array('Login', 'Password', 'Lang', 'Group', 'Name', 'Email', 'Published', 'EditLang');

	function __construct(){

        parent::__construct();
		
		$this->templatePath = dirname(__FILE__).'/templates/users/';
        $this->smarty->addTemplateDir($this->templatePath);

		$this->table = DB_PREFIX.'users';

        $this->joins[] = " LEFT JOIN ".DB_PREFIX."users_data USING(ID)";
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
        return $this->smarty->fetch($this->templatePath . '/table.tpl', null, $this->language);
    }

    function prepareFormData($id=""){
        $langs = LanguageService::getInstance()->getAll();
        $this->smarty->assign("langs", $langs);

        $groups_query = "SELECT Name FROM ".DB_PREFIX."users_groups";
        $this->getOptions($groups_query, 'groups');
		parent::prepareFormData($id);
	}
	
    function prepareData($data){
//        $data['LoginRequired'] = isset($data['LoginRequired']) ? (int)$data['LoginRequired'] : 0;
////        $data['ViewCount'] = (int)$data['LoginRequired'];
//        if (!isset($data['Url']) || empty($data['Url'])) $data['Url'] = Translit::makeUrl($data['Title']);
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