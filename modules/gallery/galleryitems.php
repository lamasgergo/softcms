<?php

class GalleryItems{

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
  	var $random;
  	var $limit;
  	var $cid;
	var $url;
	
	
	function GalleryItems($moduleName, $id, $cid=0, $random=0, $limit=100, $tpl='item_detail.tpl', $url=''){
		global $smarty,$db,$lang,$language,$LangID, $meta;
		$this->moduleName = $mod_name;
		$this->db = $db;
		$this->smarty = $smarty;
		$this->lang = $lang;
		$this->language = $language;
		$this->LangID = $LangID;
		
		$this->meta = &$meta;
		
		$this->uploadDir = galleryUploadDirectory;
    	$this->uploadDirURL = galleryUploadDirectoryURL;

		$this->id = $id;
		$this->random = $random;
		$this->tpl = $tpl;
		
		$this->limit = $limit;
		$this->cid = $cid;
		if (!empty($url)){
			$this->url = $url;
		}
		
	}
	

	function getInfo(){
		$sql = "";
		$items = array();
			$sql = "SELECT * FROM ".GAL_PREFIX."item WHERE ID='".$this->id."'";
		$sql = $this->db->prepare($sql);
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			$items = $res->getArray();
		}
		
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
		
		$this->smarty->assign("url",$this->url);
		$this->smarty->assign("moduleName",$this->moduleName);
		$this->smarty->assign("item_arr",$items);
		$this->smarty->assign("random",$this->random);
		$this->smarty->assign("limit",$this->limit);
		return $this->smarty->fetch(strtolower($this->moduleName)."/".$this->tpl,null,$this->language);
	}
}
?>