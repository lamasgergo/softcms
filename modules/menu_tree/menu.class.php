<?php
class MenuTree{
	var $moduleName;	
	var $tpl;
	
	var $block_vars;
	var $dynamic;
	
	var $db;
	var $smarty;
	var $lang;
	var $language;
	var $LangID;
	var $parentID=0;
	
	var $limitDepth = 2;

	function MenuTree($block_vars,$dynamic){
		global $smarty,$db,$lang,$language,$LangID;
		$this->moduleName = 'Menu_Tree';		
		$this->db = $db;
		$this->smarty = $smarty;
		$this->lang = $lang;
		$this->language = $language;
		$this->LangID = $LangID;

		$this->tpl = "menu_tree.tpl";
		
		$this->block_vars = $block_vars;
		$this->dynamic = $dynamic;
		
		$this->getVars();
	}
	
	function getVars(){
		
		if (isset($this->block_vars["tpl"]) && !empty($this->block_vars["tpl"])){
			$this->tpl = $this->block_vars["tpl"].'.tpl';
		}
		if (isset($this->block_vars["depth"]) && !empty($this->block_vars["depth"])){
			$this->depth = $this->block_vars["depth"];
		}	
		if (isset($this->block_vars["parentID"]) && !empty($this->block_vars["parentID"])){
			$this->parentID = $this->block_vars["parentID"];
		}	
	}
	
	function getTreeList($parent_id=0, $ret=array(), $depth=0){
		$depth++;
		$sql = "SELECT * FROM ".DB_PREFIX."menutree WHERE ParentID='".$parent_id."' AND LangID='".$this->LangID."' AND Published='1' ORDER BY OrderNum";
		$res = $this->db->Execute($sql);
		
		if ($res && $res->RecordCount() > 0 && $depth <=$this->limitDepth){
			$i = 0;
			while (!$res->EOF){
				$i++;
				$node['depth'] = $depth;
				if($this->selectedItem==$res->fields['ID']){
					$node['current'] = true;
				} else {
					$node['current'] = false;	
				}
				$node['id'] = $res->fields["ID"];
				$node['name'] = $res->fields["Name"];
				$node['parentid'] = $this->getParent($res->fields["ID"]);
				$node['link'] = $this->prepareLink($res->fields["Link"],$res->fields["LinkAlias"], $res->fields['ID']);
				
				if ($res->fields["External"]=="1"){
					$node['external'] = true;
				} else $node['external'] = false;
				
				$ret[] = $node;
				$ret = $this->getTreeList($res->fields["ID"], $ret, $depth);
				
				$res->MoveNext();
			}
			
		}
		return $ret;
	}
	
	function getParent($id){
		$ret = 0;
		$sql = $this->db->prepare("SELECT ParentID FROM ".DB_PREFIX."menutree WHERE ID='".$id."'");
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			$ret = $res->fields['ParentID'];
		}
		return $ret;
	}
	
	function appendChilds($items){
		foreach ($items as $id=>$item){
			$sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."menutree WHERE ParentID='".$item['id']."' ORDER BY OrderNum");
			$res = $this->db->Execute($sql);
			if ($res && $res->RecordCount() > 0){
				while (!$res->EOF){
					$node['id'] = $res->fields["ID"];
					$node['name'] = $res->fields["Name"];
					$node['parentid'] = $this->getParent($res->fields["ID"]);
					$node['link'] = $this->prepareLink($res->fields["Link"],$res->fields["LinkAlias"], $res->fields['ID']);
					
					$items[$id]['childs'][] = $node;
					
					$res->MoveNext();
				}
			} else {
				$items[$id]['childs'] = array();
			}
		}
		return $items;
	}
	
	function getInfo(){
	
		$this->selectedItem = intval(intval($_GET['menuId']));
		$this->selectedItemParent = $this->getParent($this->selectedItem);
		
		$this->limitDepth = 1;
		$items = $this->getTreeList($this->parentID);
		$items = $this->appendChilds($items);
		
		return $items;
	}
	
	function prepareLink($link="", $link_alias="",  $id=''){
		if ($link_alias!=''){
			return '/'.$link_alias;
		} 
		if ($link!='#'){
			return PageHelper::getStaticLink($link.'&menuId='.$id);
		} 
		return $link;
		 
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
		$this->smarty->assign("item_current",$this->selectedItem);
		$this->smarty->assign("item_parentid",$this->selectedItemParent);
		return $this->smarty->fetch(strtolower($this->moduleName)."/".$this->tpl,null,$this->language);
	}
}
?>
