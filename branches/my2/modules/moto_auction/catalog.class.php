<?php

require_once(MODULES_DIR."/".$mod_name."/itemlist.php");
require_once(MODULES_DIR."/".$mod_name."/itemdetails.php");
require_once(MODULES_DIR."/".$mod_name."/historylist.php");

class Catalog{
	var $block_vars;
	var $dynamic;
	var $moduleName; // module name
	
	var $obj;

	// vars for classes
	//common
	var $mode;
	var $id;
	var $page;
	//autolist
	var $place;

	var $auctionName;
	
	function Catalog($mod_name, $block_vars,$dynamic){
		$this->moduleName = $mod_name;
		$this->block_vars = $block_vars;
		$this->dynamic = $dynamic;
		
		$this->getVars();
		
		switch ($this->mode){
			case "details":
				$this->obj = new ItemDetails($this->moduleName, $this->id);
				break;
			case "historylist":
				$this->obj = new HistoryList($this->moduleName, $this->page);
				break;
			case "list":
			default:
				$this->obj = new ItemList($this->moduleName, $this->page);
				$this->obj->checkExpiredItems();
				break;
		}
	}
		
	function getVars(){
		if ($this->dynamic==false){
			if (isset($this->block_vars["mode"]) && !empty($this->block_vars["mode"])){
				$this->mode = $this->block_vars["mode"];
			}
			if (isset($this->block_vars["id"]) && !empty($this->block_vars["id"])){
				$this->id = $this->block_vars["id"];
			}
			if (isset($this->block_vars["name"]) && !empty($this->block_vars["name"])){
				$this->auctionName = $this->block_vars["name"];
			}
		} else {
			if (isset($_GET["mode"]) && !empty($_GET["mode"])){
				$this->mode = strval($_GET["mode"]);
			}
			if (isset($_GET["id"]) && !empty($_GET["id"])){
				$this->id = intval($_GET["id"]);
			}
			if (isset($_GET["page"]) && !empty($_GET["page"])){
				$this->page = intval($_GET["page"]);
			}
			if (isset($_GET["name"]) && !empty($_GET["name"])){
				$this->auctionName = strval($_GET["name"]);
			}
		}
	}
	
	
	
	function show(){
		return $this->obj->show();
	}
}
?>
