<?php
class CatalogNewItems{
	var $moduleName;	
	var $tpl;
	
	var $block_vars;
	var $dynamic;
	
	var $db;
	var $smarty;
	var $lang;
	var $language;
	var $LangID;
	
	var $count=10;
	var $columns = 2;
	
	var $uploadDir;
	var $uploadDirURL;
	
	
	function CatalogNewItems($block_vars,$dynamic){
		global $smarty,$db,$lang,$language,$LangID;
		$this->moduleName = 'catalog';		
		$this->db = $db;
		$this->smarty = $smarty;
		$this->lang = $lang;
		$this->language = $language;
		$this->LangID = $LangID;

		$this->tpl = "new.tpl";
		
		$this->block_vars = $block_vars;
		$this->dynamic = $dynamic;
		
		$this->uploadDir = catalogUploadDirectory;
		$this->uploadDirURL = catalogUploadDirectoryURL;
		
		$this->getVars();
	}
	
	function getVars(){
		if ($this->dynamic==false){
		  if (isset($this->block_vars["tpl"]) && !empty($this->block_vars["tpl"])){
			$this->tpl = $this->block_vars["tpl"];
		  }
		  if (isset($this->block_vars["count"]) && !empty($this->block_vars["count"])){
			$this->count = $this->block_vars["count"];
		  }
		} else {
			if (isset($this->block_vars["tpl"]) && !empty($this->block_vars["tpl"])){
				$this->tpl = $this->block_vars["tpl"].'.tpl';
			}
			if (isset($this->block_vars["count"]) && !empty($this->block_vars["count"])){
				$this->count = $this->block_vars["count"];
			}	
		}
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
	
	function getInfo(){
		$items = array();
		$sql = $this->db->prepare("SELECT * FROM ".CAT_PREFIX."item ORDER BY Created DESC LIMIT 0,". $this->count);
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			$items = $res->getArray();
		}
		return $items;
	}
	
	
	function show(){
		$this->smarty->assign("columns", $this->columns);
		$this->smarty->assign("uploadDir",$this->uploadDir);
		$this->smarty->assign("uploadDirURL",$this->uploadDirURL);
		$this->smarty->assign("currency", $this->getCurrency());
		$this->smarty->assign("item_arr",$this->getInfo());
		$this->smarty->assign("mod_name",$this->moduleName);
		return $this->smarty->fetch(strtolower($this->moduleName)."/".$this->tpl,null,$this->language);
	}
}
?>
