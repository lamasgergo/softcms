<?php

class ItemDetails{

	var $moduleName; // module name
	var $tpl; // tpl to show
	
	var $db;
	var $smarty;
	var $lang;
	var $language;
	var $LangID;
	
	var $integration;
	
	var $id;
	
	var $meta; //meta-data
	
	var $uploadDir;
  	var $uploadDirURL;
  	
  	var $data;
	
	
	function ItemDetails($mod_name, $id){
		global $smarty,$db,$lang,$language,$LangID, $meta;
		$this->moduleName = $mod_name;
		$this->db = $db;
		$this->smarty = $smarty;
		$this->lang = $lang;
		$this->language = $language;
		$this->LangID = $LangID;
		
		$this->meta = &$meta;
		
		$this->uploadDir = catalogUploadDirectory;
    	$this->uploadDirURL = catalogUploadDirectoryURL;

		$this->id = $id;
		
		$this->getInfo();
	}
	

	function getInfo(){
		$sql = "";
		$items = array();
		if (!empty($this->id)){
			$sql = "SELECT * FROM ".CAT_PREFIX."item WHERE ID='".$this->id."'";
			$sql = $this->db->prepare($sql);
			$res = $this->db->Execute($sql);
			if ($res && $res->RecordCount() > 0){
				$items = $res->getArray();
			}
		}
		$this->data = $items[0];
		
		$this->tpl = "details.tpl";
		return $items;
	}
	
	function getCurrency(){
		$cur = array();
		$sql = $this->db->prepare("SELECT ID, Value FROM ".DB_PREFIX."currency");
		$res = $this->db->Execute($sql);
		while (!$res->EOF){
			$cur[$res->fields['ID']] = $res->fields['Value'];
			$res->MoveNext();
		}
		return $cur;
	}

	function show(){
		$this->smarty->assign("currency", $this->getCurrency());
		$this->smarty->assign("uploadDir",$this->uploadDir);
  		$this->smarty->assign("uploadDirURL",$this->uploadDirURL);
		
		$items = $this->data;
		
		$this->meta->set_title($items['MetaTitle']);
		$this->meta->set_description($items['MetaDescription']);
		$this->meta->set_keywords($items['MetaKeywords']);
		$this->meta->set_alt($items['MetaAlt']);
		
		$this->smarty->assign("mod_name",$this->moduleName);
		$this->smarty->assign("item_arr",$items);
		return $this->smarty->fetch(strtolower($this->moduleName)."/".$this->tpl,null,$this->language);
	}
}
?>