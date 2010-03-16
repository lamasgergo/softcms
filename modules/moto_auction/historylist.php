<?php
class HistoryList{
	
	var $moduleName; // module name
	var $tpl; // tpl to show
	

	var $db;
	var $smarty;
	var $lang;
	var $language;
	var $LangID;
	var $user;
	var $xajax;
	
	var $where = array('Published="1"');
	
	var $page; //navigation page
	var $navigationLimit; // items per page
	
	var $priceUpValue = 100;

	var $uploadDir;
	var $uploadDirURL;
	
	function HistoryList($mod_name, $page = 0){
		global $smarty, $db, $lang, $language, $LangID, $user, $xajax;
		
		$this->moduleName = $mod_name;
		$this->db = &$db;
		$this->smarty = &$smarty;
		$this->user = &$user;
		$this->xajax = &$xajax;
		$this->lang = $lang;
		$this->language = $language;
		$this->LangID = $LangID;
		$this->where = array();
		
		$this->page = $page;
		$this->navigationLimit = navigationLimit;
		$this->where[] = 'StartDate<CURRENT_DATE()';
	}
	
	function getInfo(){
		$sql = "";
		$items = array();
		$sql = "SELECT i.*, p.Price as userPrice FROM " . MOTO_AUC_PREFIX . "item AS i LEFT JOIN ".MOTO_AUC_PREFIX."prices AS p ON (p.ItemID=i.ID)";
		$sql .= (count($this->where) > 0) ? ' WHERE ' . implode(" AND ", $this->where) : '';
		$sql .= " ORDER BY StartDate ASC";
		$sql .= " LIMIT " . $this->navigationLimit * $this->page . "," . $this->navigationLimit.";";
		$sql = $this->db->prepare($sql);
		$this->tpl = "historylist.tpl";
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
		$sql = $this->db->prepare("SELECT COUNT(ID) as cnt FROM " . MOTO_AUC_PREFIX . "item");
		$sql .= (count($this->where) > 0) ? ' WHERE ' . implode(" AND ", $this->where) : '';
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0) {
			$count = $res->fields["cnt"];
		}
		$nav = new Navigator($count, $this->navigationLimit, $this->page);
		$nav->tpl = 'nav_all.tpl';
		$link = 'index.php?mod=' . $this->moduleName . '&mode=historylist';
		return $nav->show($link);
	}
	
	function show(){
		$this->smarty->assign("uploadDir", $this->uploadDir);
		$this->smarty->assign("uploadDirURL", $this->uploadDirURL);
		$this->smarty->assign("mod_name", $this->moduleName);
		$this->smarty->assign("item_arr", $this->getInfo());
		$this->smarty->assign("navigation", $this->Navigation());
		return $this->smarty->fetch(strtolower($this->moduleName) . "/" . $this->tpl, null, $this->language);
	}
	
}
?>