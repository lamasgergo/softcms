<?php

require_once (dirname(__FILE__)."/../../modules/article/items.php");

class Images extends Items {

    protected $type = 'images';
    protected $tmpStorePath = '/files/tmp/';
    protected $storePath = '/files/images/';

	function __construct(){

        parent::__construct();

        $this->templatePath = dirname(__FILE__).'/templates/items/';

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
                $this->saveUploaded($this->db->Insert_ID($this->table), $data['src']);
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
                $this->saveUploaded($data['ID'], $data['src']);
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
        $tmpStorePath = $_SERVER['DOCUMENT_ROOT'] . $this->tmpStorePath;

        if (!file_exists($tmpStorePath)){
            @mkdir($tmpStorePath);
            @chmod($tmpStorePath, 0777);
        }

        $filename = basename($_FILES['src']['name']);
        if (move_uploaded_file($_FILES['src']['tmp_name'],  $_SERVER['DOCUMENT_ROOT']. $this->tmpStorePath . $filename)) {
            $data = array('filename' => $filename);
            $data = array('src' => $this->tmpStorePath . $filename);
        } else {
            $data = array('error' => 'Failed to save');
        }
//        header('Content-type: text/html');
        return json_encode($data);
    }

    function saveUploaded($DataID, $files=array()){
        if (empty($files)) return false;

        $storePath = $_SERVER['DOCUMENT_ROOT'] . $this->storePath;
        $tmpStorePath = $_SERVER['DOCUMENT_ROOT'] . $this->tmpStorePath;

        if (!file_exists($storePath)){
            @mkdir($storePath);
            @chmod($storePath, 0777);
        }

        if (is_array($files)){
            $result = true;
            foreach ($files as $file){
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . $file)){
                    $newFile = str_replace($this->tmpStorePath, $this->storePath, $file);
                    if (@copy($_SERVER['DOCUMENT_ROOT'] . $file, $_SERVER['DOCUMENT_ROOT'] . $newFile)){
                        @unlink($_SERVER['DOCUMENT_ROOT'] . $file);
                        $file = $newFile;
                    }
                    $query = $this->db->Prepare("INSERT INTO ".DB_PREFIX."images(`DataID`,`Src`) VALUES ('{$DataID}','{$file}')");
                    if (!$this->db->Execute($query)) $result = false;
                }
            }
            return $result;
        } else {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $files)){
                $newFile = str_replace($this->tmpStorePath, $this->storePath, $files);
                if (@copy($_SERVER['DOCUMENT_ROOT'] . $files, $_SERVER['DOCUMENT_ROOT'] . $newFile)){
                    @unlink($_SERVER['DOCUMENT_ROOT'] . $files);
                    $files = $newFile;
                }
                $query = $this->db->Prepare("INSERT INTO ".DB_PREFIX."images(`DataID`,`Src`) VALUES ('{$DataID}','{$files}')");
                if ($this->db->Execute($query)){
                    return true;
                }
            }
        }
        return false;
    }

    function prepareFormData($id=""){
        echo $images_query = "SELECT * FROM ".DB_PREFIX."images WHERE DataID='{$id}'";
        $this->getOptions($images_query, array('Src', 'Src'), array('images_src', 'images_src2'));
		parent::prepareFormData($id);
	}
}
?>