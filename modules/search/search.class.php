<?php

require_once(MODULES_DIR."/search/contentsearch.php");
require_once(MODULES_DIR."/search/catalogsearch.php");

class Search{
	var $obj;

	// vars for classes
	//common
	var $mode;
	var $id;
	var $page;
	var $search;
	var $search_arr = array();
	
	var $moduleName;
	

	function Search($moduleName){
		$this->moduleName = $mod_name;
		
		$this->getVars();
		$this->getSearchArr();
		switch ($this->mode){
			case 'catalog':
				$this->obj = new SearchCatalog($this->moduleName, $this->search_arr, $this->page);
			break;
			default:
				$this->obj = new SearchContent($this->moduleName, $this->search_arr, $this->page);
			break;
		}
	}
		
	 function getVars(){
			if (isset($_GET["mode"]) && !empty($_GET["mode"])){
				$this->mode = strval($_GET["mode"]);
			}
			if (isset($_GET["id"]) && !empty($_GET["id"])){
				$this->id = intval($_GET["id"]);
			}
			if (isset($_GET["page"]) && !empty($_GET["page"])){
				$this->page = intval($_GET["page"]);
			}
			if (isset($_GET["text"]) && !empty($_GET["text"])){
				$this->search = strval($_GET["text"]);
			}
	}
	
	
	 function getSearchArr(){
		if (!empty($this->search)){
			$search_text = preg_replace("/[\= \( \) \[ \] \" \' \, \\ \/ \| \. \$ \s]+/si"," ",$this->search);
			if (strlen($search_text) > 0){
				$search_text_arr = array();
	  			$search_text_arr_tmp = explode(" ",$search_text);
	  			foreach($search_text_arr_tmp as $key=>$val){
	    			if (preg_match("/[\w\d\-\_а-я]/ui",$val)){
	      				array_push($this->search_arr,$val);
	    			}
	  			}
			}
		}
	}
	
	
	 function show(){
	 
		if ($this->dynamic===true){
			$this->smarty->assign("breadcrumbs", showBreadCrumbs($this->getPath()));
		}
		
		return $this->obj->show();
	}
}
?>
