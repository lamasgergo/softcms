<?php

require_once (dirname(__FILE__)."/../../modules/article/items.php");

class Images extends Items {

    protected $type = 'images';

	function __construct(){

        parent::__construct();

        $this->templatePath = dirname(__FILE__).'/templates/items/';

        $this->joins[] = 'LEFT JOIN '.DB_PREFIX.'images ON (DataID=ID)';
	}
	
	
	function getName(){
		return strtolower(__CLASS__);                    
	}
	
	//set common template vars
	function setTemplateVars() {
        $this->smarty->assign("module", $this->moduleName);
        $this->smarty->assign("component", $this->getName());
    }


    function prepareData($data){
        $data['InMenu'] = isset($data['InMenu']) ? (int)$data['InMenu'] : 0;
        if (!isset($data['SEOName']) || empty($data['SEOName'])) $data['SEOName'] = Translit::makeUrl($data['Title']);
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
        var_dump($_POST);
        var_dump($_FILES);
        die();
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
            $items = new Items($this->moduleName);
            $items->delete($ids);
            $result = true;
        } else {
            $msg = Locale::get("Error deleting", $this->getName());
            $result = false;
        }

        return array($result, $msg);
    }

    function Upload(){
        $filename = basename($_FILES['src']['name']);
        if (move_uploaded_file($_FILES['src']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/files/' . $filename)) {
            $data = array('filename' => $filename);
            $data = array('src' => '/files/'.$filename);
        } else {
            $data = array('error' => 'Failed to save');
        }
//        header('Content-type: text/html');
        return json_encode($data);
    }
}
?>