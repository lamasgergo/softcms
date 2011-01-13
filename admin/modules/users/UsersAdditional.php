<?php

require_once (dirname(__FILE__)."/../../classes/tabelement.php");

class UsersAdditional extends TabElement {

    protected $type = 'users';

    protected $dependsOnType = false;

    protected $fields = array('ID', 'Familyname', 'Patronymic', 'Country', 'City', 'Address', 'Address2', 'ZIP', 'Phone', 'Cellphone');

    protected $gridFields = array();

    protected $requiredFields = array('Familyname', 'Country', 'City', 'Address', 'ZIP', 'Phone');

    protected $formTemplate = 'form_additional.tpl';

	function __construct(){

        parent::__construct();

		$this->templatePath = dirname(__FILE__).'/templates/users/';
        $this->smarty->addTemplateDir($this->templatePath);

		$this->table = DB_PREFIX.'users_data';
	}


	function getName(){
		return strtolower(__CLASS__);
	}

	//set common template vars
	function setTemplateVars() {
        $this->smarty->assign("module", $this->moduleName);
        $this->smarty->assign("component", $this->getName());
    }

    function add($data) {
        $result = true;
        if ($this->checkRequiredFields($data)) {
            if (!parent::add($data)) {
                $result = false;
            }
        } else {
            $result = false;
        }
        return $result;
    }

    function formData($id="", $action=''){
        $this->prepareFormData($id, $action);
        if (!empty($id)){
            $this->id = $id;
			$query = $this->getQuery();
			$rs = $this->db->Execute($query);
			if ($rs && $rs->RecordCount() > 0){

				$values = $rs->GetArray();
				$this->smarty->assign("items_arr",$values);

			} else $this->smarty->assign("items_arr",array());
		} else {
			$this->smarty->assign("items_arr",array());
			$this->smarty->assign("after_checked","checked");
		}
        $this->smarty->assign("debug", Log::getInstance()->get());
    }

    function change($data) {
        $result = true;
        if ($this->checkRequiredFields($data)) {
            $data = $this->prepareData($data);
            $upd = array();
            foreach ($data as $field=>$value){
                $upd[] = "`".$field."` = '".$value."'";
            }
            $query = $this->db->Prepare("REPLACE INTO " . $this->table . " SET ".implode(",", $upd));
            if (!$this->db->Execute($query)){
                $result = false;
            }
        } else {
            $result = false;
        }

        return $result;
    }

    function delete($data) {
        $ids = parent::delete($data);
        if (count($ids) > 0) {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }
}
?>