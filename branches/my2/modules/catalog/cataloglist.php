<?php
class CatalogList{
	
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
	
	var $subCatalogLimit = catalog_subcategories_limit;
	var $columns = catalog_categories_per_row;
	
	function CatalogList($mod_name, $categoryID, $page = 0){
		global $smarty, $db, $lang, $language, $LangID, $meta;
		
		$this->uploadDir = catalogUploadDirectory;
		$this->uploadDirURL = catalogUploadDirectoryURL;
		
		$this->moduleName = $mod_name;
		$this->db = $db;
		$this->smarty = $smarty;
		$this->lang = $lang;
		$this->language = $language;
		$this->LangID = $LangID;
		
		$this->meta = &$meta;
		
		$this->parentID = $categoryID;
		
		$this->where = array();
	
	}
	
	function getInfo(){
		$this->where[] = "ParentID='".$this->parentID."'";
		$sql = "";
		$items = array();
		$sql = "SELECT * FROM " . CAT_PREFIX . "category";
		$sql .= (count($this->where) > 0) ? ' WHERE ' . implode(" AND ", $this->where) : '';
		$sql .= ' ORDER BY Name ASC';
		$sql = $this->db->prepare($sql);
		$this->tpl = "cataloglist.tpl";
		if (! empty($sql)) {
			$res = $this->db->execute($sql);
			if ($res && $res->RecordCount() > 0) {
				$items = $res->GetArray();
			}
		}
		return $items;
	}
	
	function getSubcatalogs(){
		$catalogs = array();
		$sql = "SELECT ID, LinkAlias FROM " . CAT_PREFIX . "category ORDER BY Name ASC";
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			while (!$res->EOF){
				$sql = "SELECT ID, Name, LinkAlias FROM " . CAT_PREFIX . "category WHERE ParentID='".$res->fields['ID']."' ORDER BY Name ASC";
				if ($this->subCatalogLimit!=0){
					$sql .= " LIMIT 0,".$this->subCatalogLimit;
				}
				$res2 = $this->db->Execute($sql);
				if ($res2 && $res2->RecordCount() > 0){
					while (!$res2->EOF){
						$catalogs[$res->fields['ID']][] = array(
																"ID" => $res2->fields['ID'],
																"Name" => $res2->fields['Name'],
																"LinkAlias" => $res2->fields['LinkAlias']
																);
						$res2->MoveNext();
					}
				}
				$res->MoveNext();
			}
		}
		return $catalogs;
	}
	
	function show(){
		
		$items = $this->getInfo();
	
		$this->smarty->assign("columns", $this->columns);
		$this->smarty->assign("uploadDir", $this->uploadDir);
		$this->smarty->assign("uploadDirURL", $this->uploadDirURL);
		$this->smarty->assign("mod_name", $this->moduleName);
		$this->smarty->assign("item_arr", $items);
		$this->smarty->assign("subcatalogs_arr", $this->getSubcatalogs());
		return $this->smarty->fetch(strtolower($this->moduleName) . "/" . $this->tpl, null, $this->language);
	}
}
?>