<?php
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
	
	function ItemList($moduleName, $page = 0){
		global $smarty, $db, $lang, $language, $LangID;
		
		$this->uploadDir = catalogUploadDirectory;
		$this->uploadDirURL = catalogUploadDirectoryURL;
		
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
		$this->where[] = "Published='1'";
		if (isset($_GET["categoryid"]) && !empty($_GET["categoryid"])){
			$catid=0;
			$itemName='';
			list($catid, $itemName) = explode(",",$_GET["categoryid"]);
			$catid = intval($catid);
			$itemName = trim(strval($itemName));
			if ($catid!=0 && $itemName!=''){
				$this->where[] = "(CategoryID='".$catid."' AND Name='".$itemName."')";
			}
		}
		if (isset($_GET["class"]) && !empty($_GET["class"])){
			$class = trim(strval($_GET["class"]));
			$this->where[] = "Class='".$class."'";
		}
	}
	
	function getInfo(){
		$sql = "";
		$items = array();
		$sql = "SELECT * FROM " . MOTO_CAT_PREFIX . "item";
		$sql .= (count($this->where) > 0) ? ' WHERE ' . implode(" AND ", $this->where) : '';
		$sql .= " ORDER BY ID DESC";
		$sql .= " LIMIT " . $this->navigationLimit * $this->page . "," . $this->navigationLimit;
		$sql = $this->db->prepare($sql);
		if (!isset($this->tpl) || empty($this->tpl)){
			$this->tpl = "list.tpl";
		}
		if (! empty($sql)) {
			$res = $this->db->execute($sql);
			if ($res && $res->RecordCount() > 0) {
				$items = $res->GetArray();
			}
		}
		return $items;
	}
	
	function Navigation(){
		$count = 0;
		$sql = $this->db->prepare("SELECT COUNT(ID) as cnt FROM " . MOTO_CAT_PREFIX . "item");
		$sql .= (count($this->where) > 0) ? ' WHERE ' . implode(" AND ", $this->where) : '';
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0) {
			$count = $res->fields["cnt"];
		}
		$nav = new Navigator($count, $this->navigationLimit, $this->page);
		$nav->tpl = 'nav_all.tpl';
		$link = 'index.php?mod=' . $this->moduleName . '&mode=list';
		if ($_GET['categoryid']){
			$link .= '&categoryid='.$_GET['categoryid'];
		}
		if ($_GET['class']){
			$link .= '&class='.$_GET['class'];
		}
		return $nav->show($link);
	}
	
	function show(){
		$this->smarty->assign("uploadDir", $this->uploadDir);
		$this->smarty->assign("uploadDirURL", $this->uploadDirURL);
		$this->smarty->assign("moduleName", $this->moduleName);
		$this->smarty->assign("item_arr", $this->getInfo());
		$this->smarty->assign("navigation", $this->Navigation());
		$this->filterData();
		return $this->smarty->fetch(strtolower($this->moduleName) . "/" . $this->tpl, null, $this->language);
	}
	
	function filterData(){
		// ParentID
		$parent_arr = $this->getCategoryItemList();
		$parent_ids = array();
		$parent_names = array();
		foreach ( $parent_arr as $parent ) {
			$parent_ids[] = $parent["id"];
			$parent_names[] = $parent["name"];
		}
		$this->smarty->assign("category_ids", $parent_ids);
		$this->smarty->assign("category_names", $parent_names);
		
		//class
		$class = array('Allround', 'ATV', 'Classic', 'Cross', 'Custom / cruiser', 'Dragster', 'Enduro / offroad', 'Minibike', 'Naked bike', 'Scooter', 'Sport touring', 'Super motard', 'Supersport', 'Touring', 'Trial');
		$class_ids = array();
		$class_names = array();
		foreach ( $class as $item ) {
			$class_ids[] = $item;
			$item_name = $item;
			if (isset($this->lang[$item]) && ! empty($this->lang[$item])) {
				$item_name = $this->lang[$item];
			}
			$class_names[] = $item_name;
		}
		$this->smarty->assign("class_ids", $class_ids);
		$this->smarty->assign("class_names", $class_names);
	}
	
	function getCategoryItemList(){
		$sql = "SELECT CONCAT(c.ID, ',', i.Name) as ID, CONCAT(c.Name, ' / ', i.Name) as Name FROM ".MOTO_CAT_PREFIX."category as c, ".MOTO_CAT_PREFIX."item as i WHERE i.CategoryID=c.ID GROUP BY i.Name ORDER BY c.Name ASC";
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0) {
			while ( ! $res->EOF ) {
				$ret[] = array('id' => $res->fields["ID"], 'name' => $depth_str . $res->fields["Name"]);
				$res->MoveNext();
			}
		}
		return $ret;
	}
}
?>