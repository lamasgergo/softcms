<?php
class Calendar{
	var $moduleName;
	var $tpl;
	var $template;

	var $db;
	var $smarty;
	var $lang;
	var $language;
	var $LangID;

	var $block_vars;
	var $dynamic;
	
	var $cid; // category id
	var $pid; // parent id
	var $iid; // item id
	var $lid; // show last item from category

	var $page;
	var $max_per_page;
	var $where;
	
	var $meta;
	
	function Calendar($block_vars,$dynamic,$page=0){
		global $smarty,$db,$lang,$language,$LangID, $meta;
		$this->moduleName = 'news_archive';
		$this->db = $db;
		$this->smarty = $smarty;
		$this->lang = $lang;
		$this->language = $language;
		$this->LangID = $LangID;

		$this->page = $page;
		$this->navigationLimit = navigationLimit;
		$this->where = array();

		$this->block_vars = $block_vars;
		$this->dynamic = $dynamic;
		
		$this->tpl = 'calendar.tpl';
		
		$this->getVars();
	}

	function getVars(){
		if ($this->dynamic==false){
			if (isset($this->block_vars["cid"]) && !empty($this->block_vars["cid"])){
				$this->cid = $this->block_vars["cid"];
				$this->where[] = "CategoryID='".$this->cid."'";
			}
		} else {
			if (isset($_GET["cid"]) && !empty($_GET["cid"])){
				$this->cid = intval($_GET["cid"]);
				$this->where[] = "CategoryID='".$this->cid."'";
			}
		}
	}
	

	
	function getInfo(){
		$sql = "";
		$items = array();
		
		if (!empty($this->cid)){
			$this->where[] = "Published='1'";
			$sql = $this->db->prepare("SELECT DATE_FORMAT(Created, '%c-1-%Y') as start_date, DATE_FORMAT(Created, '%c-%e-%Y') as news_date FROM ".DB_PREFIX."cnt_item");
			$sql .= (count($this->where) > 0) ? ' WHERE '.implode(" AND ",$this->where) : '';
			$sql .= ' ORDER BY Created ASC';
		}
		
		if (!empty($sql)){
			$res = $this->db->execute($sql);
			if ($res && $res->RecordCount() > 0){
				 $items = $res->GetArray();
			}
		}
		
		return $items;
	}
	
	
	function show(){
		$items = $this->getInfo();
		$this->smarty->assign("item_arr",$items);
		$this->smarty->assign("category_id",$this->cid);

		return $this->smarty->fetch(strtolower($this->moduleName)."/".$this->tpl,null,$this->language);
	}
}
?>