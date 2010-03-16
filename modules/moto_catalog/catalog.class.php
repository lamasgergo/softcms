<?php

require_once(MODULES_DIR."/".$mod_name."/itemlist.php");
require_once(MODULES_DIR."/".$mod_name."/itemdetails.php");

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

	function Catalog($mod_name, $block_vars,$dynamic){
		$this->moduleName = $mod_name;
		$this->block_vars = $block_vars;
		$this->dynamic = $dynamic;
		
		$this->getVars();
		
		switch ($this->mode){
			case "list":
				$this->obj = new ItemList($this->moduleName, $this->page);
				if ($this->dynamic==false){
					if ($block_vars['tpl']) $this->obj->tpl = $block_vars['tpl'].'.tpl';
					if ($block_vars['limit']) $this->obj->navigationLimit = $block_vars['limit'];
				}
				break;
			case "details":
				$this->obj = new ItemDetails($this->moduleName, $this->id);
				break;
			default:
				$this->obj = new ItemList($this->moduleName, $this->page);
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
			if (isset($this->block_vars["tpl"]) && !empty($this->block_vars["tpl"])){
				$this->tpl = $this->block_vars["tpl"];
			}
			if (isset($this->block_vars["limit"]) && !empty($this->block_vars["limit"])){
				$this->tpl = $this->block_vars["limit"];
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
		}
	}
	
	
	
	function show(){
		return $this->obj->show();
	}
}
?>
