<?php
require_once($_SERVER['DOCUMENT_ROOT']."/kernel/catalognavigator.php");

class ItemList{

	var $moduleName; // module name
	var $tpl; // tpl to show

	var $db;
	var $smarty;
	var $lang;
	var $language;
	var $LangID;

	var $where;

	var $page; //navigation page
	var $navigationLimit; // items per page

	var $uploadDir;
	var $uploadDirURL;

	var $parentID;
	
	var $columns = catalog_items_per_row;


	function ItemList($moduleName, $parentID=0, $page=0){
		global $smarty,$db,$lang,$language,$LangID;

		$this->uploadDir = catalogUploadDirectory;
		$this->uploadDirURL = catalogUploadDirectoryURL;


		$this->parentID = $parentID;

		$this->moduleName = $mod_name;
		$this->db = $db;
		$this->smarty = $smarty;
		$this->lang = $lang;
		$this->language = $language;
		$this->LangID = $LangID;
		$this->where = array();

		$this->page = $page;
		$this->navigationLimit = navigationLimit;

		$this->getWhere();
	}


	function getWhere(){
		$this->where[] = "CategoryID='".$this->parentID."'";
	}

	function getInfo(){
		$sql = "";
		$items = array();
		
		$count_sql = "SELECT COUNT(*) as cnt FROM ".CAT_PREFIX."item";
		$count_sql .= (count($this->where) > 0) ? ' WHERE '.implode(" AND ",$this->where) : '';
		$count_res = $this->db->execute($count_sql);
		
		//show child products
		if ($count_res->fields['cnt']==0 && $this->parentID){
			$this->where = array();
			$this->where[] = "CategoryID IN ('".implode("','",$this->getCategoriesChildIds($this->parentID))."')";
		} 
		
		$sql = "SELECT * FROM ".CAT_PREFIX."item";
		$sql .= (count($this->where) > 0) ? ' WHERE '.implode(" AND ",$this->where) : '';
		$sql .= "ORDER BY Created DESC";
		$sql .= " LIMIT ".$this->navigationLimit*$this->page.",".$this->navigationLimit;
		
		$sql = $this->db->prepare($sql);
		$this->tpl = "list.tpl";
		if (!empty($sql)){
			$res = $this->db->execute($sql);
			if ($res && $res->RecordCount() > 0){
				$items = $res->GetArray();
			}
		}
		return $items;
	}

	function getCategoriesChildIds($parent_id=0, $ret=array(), $depth=0){
		$depth++;
		$sql = "SELECT ID, Name FROM ".CAT_PREFIX."category WHERE ParentID='".$parent_id."' ORDER BY ID";
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			while (!$res->EOF){
				$depth_str = '';
				for ($i=0; $i<$depth; $i++) $depth_str .= '-';
				$ret[] = $res->fields["ID"];

				$ret = $this->getCategoriesChildIds($res->fields["ID"], $ret, $depth);
				$res->MoveNext();
			}
		}
		return $ret;
	}
	
	function Navigation(){
		$count = 0;
		$sql = $this->db->prepare("SELECT COUNT(ID) as cnt FROM ".CAT_PREFIX."item");
		$sql .= (count($this->where) > 0) ? ' WHERE '.implode(" AND ",$this->where) : '';
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			$count = $res->fields["cnt"];
		}
		$nav = new CatalogNavigator($count,$this->navigationLimit,$this->page);
		$link = preg_replace("/\/page\/\d+/","",$_SERVER['REQUEST_URI']);
		return $nav->show($link);
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

	function show(){
		$this->smarty->assign("columns", $this->columns);
		$this->smarty->assign("currency", $this->getCurrency());
		$this->smarty->assign("uploadDir",$this->uploadDir);
		$this->smarty->assign("uploadDirURL",$this->uploadDirURL);
		$this->smarty->assign("moduleName",$this->moduleName);
		$this->smarty->assign("item_arr",$this->getInfo());
		$this->smarty->assign("navigation",$this->Navigation());
		return $this->smarty->fetch(strtolower($this->moduleName)."/".$this->tpl,null,$this->language);
	}
}
?>