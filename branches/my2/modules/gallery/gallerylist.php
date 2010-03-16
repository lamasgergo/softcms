<?php

class GalleryList{

	var $moduleName; // module name
	var $tpl; // tpl to show
	
	var $db;
	var $smarty;
	var $lang;
	var $language;
	var $LangID;
	
	var $integration;
	
	var $parentID;
	
	var $uploadDir;
  	var $uploadDirURL;
  	var $random;
  	var $limit;
  	var $cid;
	var $url;
	
	var $ids;
	
	var $count;
	var $navigationLimit;
	var $page;
	
	
	function GalleryList($mod_name, $parentID=0, $page=0, $random=0, $limit=100, $tpl='items.tpl', $url=''){
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

		$this->parentID = intval($parentID);
		$this->random = $random;
		$this->tpl = $tpl;
		
		$this->page = $page;
		$this->navigationLimit = galleryNavigationLimit;
		
		$this->limit = $limit;
		if (!empty($url)){
			$this->url = $url;
		}
		
	}
	

	function getInfo(){
		$sql = "";
		$items = array();
			$sql = $this->db->prepare("SELECT ID FROM ".GAL_PREFIX."category WHERE ParentID='".$this->parentID."'");
			$res = $this->db->Execute($sql);
			if ($res && $res->RecordCount() > 0){
				while (!$res->EOF){
					$this->ids[] = $res->fields['ID'];
					$res->MoveNext();
				}
			} else {
				$this->ids = array($this->parentID);	
			}
			$sql = "SELECT * FROM ".GAL_PREFIX."item WHERE CategoryID IN ('".implode("','", $this->ids)."')";
			if ($this->random==1){
				$sql .= " ORDER BY RAND()";
			}
			$sql .= " LIMIT ".$this->navigationLimit*$this->page.",".$this->navigationLimit;
			//$sql .= " LIMIT 0,1";
		
		$sql = $this->db->prepare($sql);
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			$items = $res->getArray();
		}
		return $items;
	}
	
	function Navigation(){
		$count = 0;
		$sql = "SELECT COUNT(ID) as cnt FROM ".GAL_PREFIX."item WHERE CategoryID IN ('".implode("','", $this->ids)."')";
		if ($this->random==1){
			$sql .= " ORDER BY RAND()";
		}
		if ($res && $res->RecordCount() > 0){
			$count = $res->fields["cnt"];	
		}
		$nav = new Navigator($count,$this->navigationLimit,$this->page);
		$nav->tpl = 'nav_all.tpl';
		$link = 'index.php?mod=' . $this->moduleName;
		if (!empty($_GET['tpl'])){
			$link .= "&tpl=".$_GET['tpl'];
		}
		if (!empty($this->cid)){
			$link .= "&cid=".$this->cid;
		}
		return $nav->show($link);
	}

	function show(){
		
		$this->smarty->assign("uploadDir",$this->uploadDir);
  		$this->smarty->assign("uploadDirURL",$this->uploadDirURL);
		
		$items = $this->getInfo();
		
		$this->smarty->assign("gallery_nav",$this->Navigation());
		
		$this->smarty->assign("url",$this->url);
		$this->smarty->assign("mod_name",$this->moduleName);
		$this->smarty->assign("item_arr",$items);
		$this->smarty->assign("random",$this->random);
		$this->smarty->assign("limit",$this->limit);
		return $this->smarty->fetch(strtolower($this->moduleName)."/".$this->tpl,null,$this->language);
	}
}
?>