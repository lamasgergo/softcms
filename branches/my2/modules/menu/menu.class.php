<?php
include_once(__PATH__."/kernel/mod_rewrite.php");

class Menu{
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
	

	function Menu($block_vars,$dynamic){
		global $smarty,$db,$lang,$language,$LangID;
		$this->moduleName = 'Menu';		
		$this->db = $db;
		$this->smarty = $smarty;
		$this->lang = $lang;
		$this->language = $language;
		$this->LangID = $LangID;
		
		$this->parentID = 0;

		$this->block_vars = $block_vars;
		$this->dynamic = $dynamic;
		
		$this->getVars();
	}
	
	function getVars(){
		global $langService;
		$url = ModRewrite::clearPath($_SERVER['REQUEST_URI']);
		
		$languages = $langService->getLanguages();

		if (in_array($url[0], $languages)){
			$lang = array_shift($url);
			$langService->setLanguage($lang);
		}
		
		$url = implode("/", $url);
		$url = preg_replace("/^\/?(.*?)\/?$/","\\1",$url);
		
		if (empty($url)) return $path;
		
		$sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."menutree WHERE LinkAlias RLIKE '\/?".$url."\/?'");
		$sql .= " AND LangID='".$langService->getLanguageID($lang)."'";
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			$this->parentID = $res->fields['ParentID'];
		}
		
	}
	
		
	function getInfo(){
		$items = array();
		$sql = "";
		$items = array();
		$sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."menutree WHERE ParentID='".$this->parentID."' AND LangID='".$this->LangID."' AND Published='1' ORDER BY OrderNum ASC");

		$this->tpl = "menu.tpl";
		if (!empty($sql)){
			$res = $this->db->execute($sql);
			if ($res && $res->RecordCount() > 0){
				while (!$res->EOF){
					$res->fields['Link'] = $this->prepareLink($res->fields["Link"],$res->fields["LinkAlias"], $res->fields['ID']);
					$items[] = $res->fields;
					$res->MoveNext();
				}
			}
		}
		
		
		return $items;
	}
	
	
	function prepareLink($link="", $link_alias="",  $id=''){
		if ($link_alias!=''){
			return '/'.$link_alias;
		} 
		if ($link!='#'){
			return LinkHelper::getStaticLink($link.'&menuId='.$id);
		} 
		return $link;
	}
	
	
	function show(){
		$this->smarty->assign("item_arr",$this->getInfo());
		return $this->smarty->fetch(strtolower($this->moduleName)."/".$this->tpl,null,$this->language);
	}
}
?>
