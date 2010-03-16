<?php
class Plot{
	var $moduleName;	
	var $tpl;
	
	var $block_vars;
	var $dynamic;
	
	var $parentID;
	
	var $db;
	var $smarty;
	var $lang;
	var $language;
	var $LangID;
	
	var $currentLinkId;
	

	function Plot($block_vars,$dynamic){
	global $smarty,$db,$lang,$language,$LangID;
		$this->moduleName = 'Plot';

		$this->db = &$db;
		$this->lang = $lang;
		$this->language = $language;
		$this->LangID = $LangID;
		$this->smarty = $smarty;

	}

	
	
	function getInfo(){
	
		$items = array();
				
		$sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."plots ORDER BY Num ASC");
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			$items = $res->getArray();
		}
		return $items;
	}
	
	
	function show(){
		$this->smarty->assign('item_arr', $this->getInfo());
		return $this->smarty->fetch(strtolower($this->moduleName)."/plot.tpl",null,$this->language);
	}
	
}
?>
