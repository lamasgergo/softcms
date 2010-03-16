<?php
require_once(__PATH__.'/admin/common/tabelement.php');
class AdminForm{

	var $tabs;
	var $name;
	var $smarty;
	var $language;
	var $lang;
	var $tabCounter;
	
	function AdminForm($name){
		global $smarty,$language,$lang;
		$this->name = $name;
		$this->smarty = $smarty;
		$this->language = $language;
		$this->lang = $lang;
		$this->tabs = array();	
		$this->tabCounter = 0;
	}
	
	function addTabElement($name,$value,$menu="",$filter=""){
		$this->tabs[] = array(
						"name"		=> $name,
						"value"		=> $value,
						"menu"		=> $menu,
						"filter"	=> $filter
						);
	}
	
	function addTabobject($obj){
		$obj->counter++; //counter+1 - number of tabs in TabElement
		$obj->tabID = $this->tabCounter;
		$this->tabs[$this->tabCounter] = array(
						"name"		=> $obj->getName(),
						"value"		=> $obj->getTabContent(),
						"menu"		=> $obj->getMenu(),
						"filter"	=> $obj->getFilter()
						);
		$this->tabCounter++;

	}
	
	function parseTabNames(){
		$names = array();
		foreach ($this->tabs as $tab){
			if (isset($this->lang[$this->name."_".strtolower($tab["name"])])) {
				$name = $this->lang[$this->name."_".strtolower($tab["name"])];
			} else $name = $this->name."_".strtolower($tab["name"]);
			array_push($names,"'".$name."'");
		}
		return implode(",",$names);
	}
	
	function show(){
		$this->smarty->assign("module",$this->name);
		$this->smarty->assign("tabs",$this->tabs);
		$this->smarty->assign("tabs_names",$this->parseTabNames());
		$this->smarty->assign("tabs_count",count($this->tabs));

        $main_tpl = $this->name.'/main.tpl';

        if (!file_exists($this->smarty->template_exists($main_tpl))){
            $main_tpl = 'admin/modules/main.tpl';
        }

		return $this->smarty->fetch($main_tpl, null, $this->language);
	}
	
}
?>