<?php
class GalleryMenu{
	var $moduleName;	
	var $tpl;
	
	var $block_vars;
	var $dynamic;
	
	var $db;
	var $smarty;
	var $lang;
	var $language;
	var $LangID;
	

	function GalleryMenu($moduleName, $block_vars="", $dynamic=""){
		global $smarty,$db,$lang,$language,$LangID;
		$this->moduleName = $mod_name;		
		$this->db = $db;
		$this->smarty = $smarty;
		$this->lang = $lang;
		$this->language = $language;
		$this->LangID = $LangID;

		$this->tpl = "menu.tpl";
		
		$this->block_vars = $block_vars;
		$this->dynamic = $dynamic;
	}
	
	function getTreeList($parent_id=0, $ret='', $depth=0){
		$depth++;
		$sql = "SELECT * FROM ".GAL_PREFIX."category WHERE ParentID='".$parent_id."' ORDER BY ID";
		$res = $this->db->Execute($sql);
		
		if ($res && $res->RecordCount() > 0){
			$ret .= "\r\n";
			for ($z=0; $z < $depth; $z++) $ret .= "\t";
			$ret .= "<ul>\r\n";
			$i = 0;
			while (!$res->EOF){
				$i++;
				for ($z=0; $z < $depth+1; $z++) $ret .= "\t";
				$ret .= "<li><a href='#'";
				$ret .= ">".$res->fields["Name"];
				$ret .= "</a>";
				$ret = $this->getTreeList($res->fields["ID"], $ret, $depth);
				$ret .= $this->getTreeItems($res->fields["ID"]);
				
				for ($z=0; $z < $depth; $z++) $ret .= "\t";
				$ret .= "</li>\r\n";
				
				$res->MoveNext();
			}
			for ($z=0; $z < $depth; $z++) $ret .= "\t";
			$ret .= "</ul>\r\n";
		}
		return $ret;
	}
	
	function getTreeItems($catalog_id, $ret='', $depth=0){
		$depth++;
		$sql = "SELECT * FROM ".GAL_PREFIX."item WHERE CategoryID='".$catalog_id."' ORDER BY ID";
		$res = $this->db->Execute($sql);
		
		if ($res && $res->RecordCount() > 0){
			$ret .= "\r\n";
			for ($z=0; $z < $depth; $z++) $ret .= "\t";
			$ret .= "<ul>\r\n";
			$i = 0;
			while (!$res->EOF){
				$i++;
				for ($z=0; $z < $depth+1; $z++) $ret .= "\t";
				$ret .= "<li><a href='/index.php?mod=gallery&id=".$res->fields['ID']."'";
				$ret .= ">".$res->fields["Name"];
				$ret .= "</a>";
				
				for ($z=0; $z < $depth; $z++) $ret .= "\t";
				$ret .= "</li>\r\n";
				
				$res->MoveNext();
			}
			for ($z=0; $z < $depth; $z++) $ret .= "\t";
			$ret .= "</ul>\r\n";
		}
		return $ret;
	}
	
	function getInfo(){
	
		$items = '';
				
		$items = $this->getTreeList();
		
		return $items;
	}
	
		
	function show(){
		$this->smarty->assign("item_arr",$this->getInfo());
		return $this->smarty->fetch(strtolower($this->moduleName)."/".$this->tpl,null,$this->language);
	}
}
?>
