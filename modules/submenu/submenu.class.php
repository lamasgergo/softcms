<?php
class SubMenu{
	var $moduleName;	
	var $tpl;
	
	var $block_vars;
	var $dynamic;
	
	var $db;
	var $smarty;
	var $lang;
	var $language;
	var $LangID;
	
	var $parentId;
	

	function SubMenu($block_vars,$dynamic){
		global $smarty,$db,$lang,$language,$LangID;
		$this->moduleName = 'SubMenu';		
		$this->db = $db;
		$this->smarty = $smarty;
		$this->lang = $lang;
		$this->language = $language;
		$this->LangID = $LangID;

		$this->tpl = "submenu.tpl";
		
		$this->block_vars = $block_vars;
		$this->dynamic = $dynamic;
		
		$this->getVars();
	}
	
	function getVars(){
		
		$parent_id = intval($_GET['id']);
		if ($parent_id){
			$this->parentId = $parent_id;
		} else {
			$this->parentId = 0;	
		}
			
	}
	
	function getTreeList($parent_id=0, $ret=array(), $depth=0){
		$depth++;
		$sql = "SELECT * FROM ".DB_PREFIX."menutree WHERE ParentID='".$parent_id."' AND LangID='".$this->LangID."' ORDER BY OrderNum";
		$res = $this->db->Execute($sql);
		
		if ($res && $res->RecordCount() > 0){
			$i=0;
			while (!$res->EOF){
				$ret[$i]['Name'] = $res->fields["Name"];
				$ret[$i]['ID'] = $res->fields["ID"];
				$ret[$i]['Link'] = $this->prepareLink($res->fields["Link"], $res->fields['ID']);
				($res->fields["External"]=="1") ? $ret[$i]['External'] = " target='_blank'" : $ret[$i]['External'] = "";
				
				$ret = $this->getTreeList($res->fields["ID"], $ret, $depth);
				
				$i++;
				$res->MoveNext();
			}
		}
		return $ret;
	}
	
	function getInfo(){
	
		$items = '';
				
		$items = $this->getTreeList($this->parentId);
		
		return $items;
	}
	
	function prepareLink($link="",$id=''){
		 if (MOD_REWRITE){
			if (preg_match("/".$_SERVER["HTTP_HOST"]."/",$link)){
				$link = preg_replace("/(http\:\/\/)?".$_SERVER["HTTP_HOST"]."(\/index.php\?)?/", "", $link);
				$link = '/'.$link;
				$link = preg_replace("/[\=\&]+/", "/", $link);
				if ($id){
					$link .= '/'.$id;
				}
				$link = $link."/index.html";
			}
			if (preg_match("/^\/?index.php\?/",$link)){
				$link = preg_replace("/\/?index.php\?/", "", $link);
				$link = '/'.$link;
				$link = preg_replace("/[\=\&]+/", "/", $link);
				if ($id){
					$link .= '/'.$id;
				}
				$link = $link."/index.html";
			}
		  } else {
		  	$link = $link . '&menuId='.$id;
		  }
		  return $link;
	}
	
	function show(){
		$this->smarty->assign("item_arr",$this->getInfo());
		return $this->smarty->fetch(strtolower($this->moduleName)."/".$this->tpl,null,$this->language);
	}
}
?>
