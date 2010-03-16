<?php

class Languages{
	var $moduleName;	
	var $tpl;
	
	var $block_vars;
	var $dynamic;
	
	var $db;
	var $smarty;
	var $lang;
	var $language;
	var $LangID;
	

	function Languages($block_vars,$dynamic){
		global $smarty,$db,$lang,$language,$LangID;
		$this->moduleName = 'Languages';		
		$this->db = $db;
		$this->smarty = $smarty;
		$this->lang = $lang;
		$this->language = $language;
		$this->LangID = $LangID;

		$this->tpl = "languages.tpl";
		
		$this->block_vars = $block_vars;
		$this->dynamic = $dynamic;
		
	}
	

	function getInfo(){
	
		$lang_ids = array();
		$lang_names = array();
		$lang_id = $this->LangID;

				
		$sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."lang ORDER BY Name ASC");
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			while (!$res->EOF){
				$lang_ids[] = $res->fields["ID"];
				$lang_names[] = $res->fields["Description"];
				$res->MoveNext();
			}
		}
		
		$this->smarty->assign("lang_ids", $lang_ids);
		$this->smarty->assign("lang_names", $lang_names);
		$this->smarty->assign("lang_id", $lang_id);
	}
	
	
	
	function show(){
		$this->getInfo();
		return $this->smarty->fetch(strtolower($this->moduleName)."/".$this->tpl,null,$this->language);
	}
}
?>
