<?php

class Banners {
	var $block_vars;
	var $dynamic;
	var $moduleName; // module name
	

	var $db;
	var $smarty;
	
	// vars for classes
	//common
	var $id;
	var $cid;
	var $random = 0;
	var $limit;
	var $tpl;
	
	function Banners($moduleName, $block_vars, $dynamic) {
		global $db, $smarty, $language;
		$this->moduleName = $mod_name;
		$this->block_vars = $block_vars;
		$this->dynamic = $dynamic;
		$this->language = $language;
		
		$this->db = &$db;
		$this->smarty = $smarty;
		
		$this->getVars ();
		$this->tpl = 'banners';
	}
	
	function getBanners(){
		$items = array();
		if ($this->cid){
			$this->where[] = "GroupID='".$this->cid."'";
		}
		if ($this->id){
			$this->where[] = "ID='".$this->id."'";
		}
		
		$sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."site_banners");
		$sql .= (count($this->where) > 0) ? ' WHERE '.implode(" AND ",$this->where) : '';
		if ($this->random==1){
			$sql .= ' ORDER BY RAND() ASC';
		}
		if ($this->limit){
			$sql .= " LIMIT ".$this->limit;
		}
		
		if (!empty($sql)){
			$res = $this->db->Execute($sql);
			if ($res && $res->RecordCount() > 0){
				 $items = $res->GetArray();
			}
		}
		return $items;
	}
	
	function getVars() {
		if (isset ( $this->block_vars ["id"] ) && ! empty ( $this->block_vars ["id"] )) {
			$this->id = $this->block_vars ["id"];
		}
		if (isset ( $this->block_vars ["cid"] ) && ! empty ( $this->block_vars ["cid"] )) {
			$this->cid = $this->block_vars ["cid"];
		}
		if (isset ( $this->block_vars ["limit"] ) && ! empty ( $this->block_vars ["limit"] )) {
			$this->limit = $this->block_vars ["limit"];
		}
		if (isset ( $this->block_vars ["tpl"] ) && ! empty ( $this->block_vars ["tpl"] )) {
			$this->tpl = $this->block_vars ["tpl"];
		}
		// must be the last
		if (isset ( $this->block_vars ["random"] ) && ! empty ( $this->block_vars ["random"] )) {
			$this->random = $this->block_vars ["random"];
		}
	}
	
	function show() {
		$this->smarty->assign ( "banners", $this->getBanners () );
		return $this->smarty->fetch ( strtolower ( $this->moduleName ) . "/" . $this->tpl . ".tpl", null, $this->language );
	}

}
?>
