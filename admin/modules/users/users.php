<?php

require_once (dirname(__FILE__)."/../../classes/tabelement.php");
require_once (dirname(__FILE__)."/UsersAdditional.php");

class Users extends TabElement {
    
    protected $type = 'users';

    protected $dependsOnType = false;

    protected $fields = array('ID', 'Login', 'Password', 'Lang', 'Group', 'Name', 'Email', 'Published', 'EditLang');

    protected $gridFields = array('ID', 'Login', 'Lang', 'Group', 'Name');

    protected $requiredFields = array('Login', 'Lang', 'Group', 'Name', 'Email', 'Published', 'EditLang');

	function __construct(){

        parent::__construct();
		
		$this->templatePath = dirname(__FILE__).'/templates/users/';
        $this->smarty->addTemplateDir($this->templatePath);

		$this->table = DB_PREFIX.'users';

//        $this->joins[] = " LEFT JOIN ".DB_PREFIX."users_data USING(ID)";
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

    function prepareFormData($id="", $action=''){
        $langs = LanguageService::getInstance()->getAll();
        $this->smarty->assign("langs", $langs);

        $users_data = new UsersAdditional();
        $this->smarty->assign("additional_form", $users_data->showForm($action, $id));

        $groups_query = "SELECT Name FROM ".DB_PREFIX."users_groups";
        $this->getOptions($groups_query, 'groups');
		parent::prepareFormData($id);
	}

    function prepareData($data){
//        $data['Published'] = isset($data['Published']) ? (int)$data['Published'] : 0;
////        $data['ViewCount'] = (int)$data['LoginRequired'];
//        if (!isset($data['Url']) || empty($data['Url'])) $data['Url'] = Translit::makeUrl($data['Title']);
        return parent::prepareData($data);
    }

    function add($data) {
        $result = true;
        if ($this->checkRequiredFields($data)) {
            if (parent::add($data)) {
                $users_data = new UsersAdditional();
                $users_data->add($data);
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
                $users_data = new UsersAdditional();
                $users_data->change($data);
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

    function changeEditLang($data){
        $this->language = $data['lang'];
        $user = User::getInstance();
        return $user->set('EditLang', $this->language);
    }
}
?>