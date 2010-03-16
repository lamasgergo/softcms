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
	}
	

	function getInfo(){
		$sql = "";
		$items = array();
		if (!empty($this->id)){
			$sql = "SELECT * FROM ".MOTO_CAT_PREFIX."item WHERE ID='".$this->id."'";
			$sql = $this->db->prepare($sql);
			$res = $this->db->Execute($sql);
			if ($res && $res->RecordCount() > 0){
				$items = $res->getArray();
			}
		}
		$this->tpl = "details.tpl";
		return $items;
	}
	

	function show(){
		
		$this->smarty->assign("uploadDir",$this->uploadDir);
  		$this->smarty->assign("uploadDirURL",$this->uploadDirURL);
		
		$items = $this->getInfo();
		
		$this->meta->set_title($items[0]['MetaTitle']);
		$this->meta->set_description($items[0]['MetaDescription']);
		$this->meta->set_keywords($items[0]['MetaKeywords']);
		$this->meta->set_alt($items[0]['MetaAlt']);
		
		$this->smarty->assign("mod_name",$this->moduleName);
		$this->smarty->assign("item_arr",$items);
		return $this->smarty->fetch(strtolower($this->moduleName)."/".$this->tpl,null,$this->language);
	}
}
?>