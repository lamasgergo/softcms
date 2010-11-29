<?php
class Map{
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
	
	var $limitDepth = 10;

	function Map($block_vars,$dynamic){
		global $smarty,$db,$lang,$language,$LangID;
		$this->moduleName = 'Map';		
		$this->db = $db;
		$this->smarty = $smarty;
		$this->lang = $lang;
		$this->language = $language;
		$this->LangID = $LangID;

		$this->tpl = "map.tpl";
		
		$this->block_vars = $block_vars;
		$this->dynamic = $dynamic;
	}
	
	
	function getTreeList($parent_id=0, $ret='', $depth=0){
		$depth++;
		$sql = "SELECT * FROM ".DB_PREFIX."menutree WHERE ParentID='".$parent_id."' AND LangID='".$this->LangID."' AND Published='1' ORDER BY OrderNum";
		$res = $this->db->Execute($sql);
		
		if ($res && $res->RecordCount() > 0 && $depth <=$this->limitDepth){
			$ret .= "\r\n";
			for ($z=0; $z < $depth; $z++) $ret .= "\t";
			$ret .= "<ul>\r\n";
			$i = 0;
			while (!$res->EOF){
				$i++;
				for ($z=0; $z < $depth+1; $z++) $ret .= "\t";
				$ret .= "<li ";
				if(intval($_GET['menuId'])==(int)$res->fields['ID']){
					$ret .= ' class="selected"';
				}
				$ret .=">";
				if ($depth==1){
					$ret .= "<div";
					if(intval($_GET['menuId'])==(int)$res->fields['ID']){
						$ret .= " class='current'";
					}
					$ret .= ">";
				}
				if(intval($_GET['menuId'])==(int)$res->fields['ID']){
					$ret .= "<div class='current'>";
					$ret .= $res->fields["Name"];
					$ret .= "</div>";
				} else {
					$ret .= "<a href='".$this->prepareLink($res->fields["Link"],$res->fields["LinkAlias"], $res->fields['ID'])."'";
					($res->fields["External"]=="1") ? $ret .= " target='_blank'" : "";
					$ret .= ">";
					$ret .= $res->fields["Name"];
					$ret .= "</a>";
				}
				if ($depth==1){
					$ret .= "</div>";	
				}
				$ret = $this->getTreeList($res->fields["ID"], $ret, $depth);
				
				if ($parent_id==0 && $i!=$res->RecordCount()){
					for ($z=0; $z < $depth+1; $z++) $ret .= "\t";
				}
				
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
				
		$items = $this->getTreeList($this->parentID);
		
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
		return $this->smarty->fetch(strtolower($this->moduleName)."/".$this->tpl,null,$this->language);
	}
}
?>
