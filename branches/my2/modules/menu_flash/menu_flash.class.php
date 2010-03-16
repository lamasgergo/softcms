<?php
class FlashMenu{
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
	

	function FlashMenu($block_vars,$dynamic){
	global $smarty,$db,$lang,$language,$LangID;
		$this->moduleName = 'FlashMenu';

		$this->db = &$db;
		$this->lang = $lang;
		$this->language = $language;
		$this->LangID = $LangID;
		$this->smarty = $smarty;

		$this->getCurrentLink();
	}

	function getTreeList($parent_id=0, $ret='', $depth=0){
		$depth++;
		$sql = "SELECT ID, UPPER(Name) as Name, Link FROM ".DB_PREFIX."menutree WHERE ParentID='".$parent_id."' AND LangID='".$this->LangID."' ORDER BY OrderNum";
		$res = $this->db->Execute($sql);
		
		if ($res && $res->RecordCount() > 0){
			$i = 0;
			while (!$res->EOF){
				$i++;
				for ($z=0; $z < $depth+1; $z++) $ret .= "\t";
				$ret .= "<menuitem ".$this->setSelectedLink($res->fields["ID"])." label='".$res->fields["Name"]."' href='".$this->prepareLink($res->fields["Link"], $res->fields['ID'])."' >";
				$ret = $this->getTreeList($res->fields["ID"], $ret, $depth);
				$ret .= "</menuitem>";
				
				$res->MoveNext();
			}
		}
		return $ret;
	}

	
	function getCurrentLink(){
		$parent_id = intval($_GET['id']);
		$menuId = intval($_GET['menuId']);
		
		if ($menuId){
			$this->currentLinkId = $menuId;
			return;	
		}
		if (!$parent_id){
			$parent_id = 0;
		}
		
		
		$sql = "SELECT ID, Link FROM ".DB_PREFIX."menutree WHERE ParentID='".$parent_id."' AND LangID='".$this->LangID."' ORDER BY OrderNum";
		
		$res = $this->db->Execute($sql);
		$links = array();
		while (!$res->EOF){
			$link = $res->fields['Link'];
			$link = preg_replace("/(http\:\/\/[^\/]+)|((www\.)?".$_SERVER['HTTP_HOST'].")|(^\#$)/", "", $link);
			if ($link){
				$links[$res->fields['ID']] = $link;
			}
			$res->MoveNext();	
		}
		
		$keys = array_keys($links);
		$this->currentLinkId = $keys[0];
		
		$sel_links = array();
		foreach ($links as $id=>$link){
			if (strpos($_SERVER['REQUEST_URI'],$link)!==false){
				$this->currentLinkId = $id;
				return ;
			}
		}
	}
	
	function setSelectedLink($id){
		if ($id == $this->currentLinkId){
			 return "selected='true'";
		}else {
			return "";	
		}
	}
	
	function prepareLink($link="", $id=''){
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
		  	$link = $link .'&menuId='.$id;
		  }
		  return $link;
	}
	
	function getInfo(){
	
		$items = '';
				
		$items = $this->getTreeList();
		
		return $items;
	}
	
	
	function show(){
		
		return $this->smarty->fetch(strtolower($this->moduleName)."/menu_flash.tpl",null,$this->language);
	}
	
	
	function xml(){
		$xml = '<menuitems>';
				
		$xml .= $this->getTreeList();
		
		$xml .= '</menuitems>';
		
		return $xml;
		$xml = '<menuitems>
                    <menuitem label="ГЛАВНАЯ" data="top"> 
                     	<menuitem label="MenuItem 1-A" data="1A"/>
                        <menuitem label="MenuItem 1-B" data="1B"/>     
                	 </menuitem>
                    <menuitem label="УСЛУГИ" data="top">
                    	<menuitem label="MenuItem 2-A" type="check"  data="2A"/>
                        <menuitem type="separator"/>
                        <menuitem label="MenuItem 2-B" >
                            <menuitem label="SubMenuItem 3-A" type="radio"
                                groupName="one" data="3A"/>
                            <menuitem label="SubMenuItem 3-B" type="radio"
                                groupName="one" data="3B"/>
                        </menuitem>
                    </menuitem>
                    <menuitem label="ЮРИДИЧЕСКИМ ЛИЦАМ" data="top"> 
                     	<menuitem label="MenuItem 1-A" data="1A"/>
                        <menuitem label="MenuItem 1-B" data="1B"/>     
                	 </menuitem>
                	 <menuitem label="ГРАЖДАНАМ" data="top">
                	 </menuitem>
                	 <menuitem label="НОРМАТИВНАЯ БАЗА" data="top">
                	 </menuitem>
                	 <menuitem label="СУДЕБНАЯ ПРАКТИКА" data="top">
                	 </menuitem>
                	 <menuitem label="ПАРТНЕРЫ" data="top">
                	 </menuitem>
                	 <menuitem label="НОВОСТИ" data="top">
                	 </menuitem>
                	 <menuitem label="КОНТАКТЫ" data="top">
                	 </menuitem>
                </menuitems>';
		return $xml;
	}
}
?>
