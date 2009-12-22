<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/admin/common/tabelement.php');
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
						"value"		=> $obj->showGrid(),
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
		$this->smarty->assign("tabs",$this->tabs);
		$this->smarty->assign("tabs_names",$this->parseTabNames());
		$this->smarty->assign("tabs_count",count($this->tabs));

        $tpl= 'main';

        if (file_exists($this->smarty->template_dir.'/modules/'.strtolower($this->name).'/templates/'.strtolower($this->name).'/'.$tpl.'.tpl')){
			return $this->smarty->fetch('modules/'.strtolower($this->name).'/templates/'.strtolower($this->name).'/'.$tpl.'.tpl', null, $this->language);
		} else {
			return $this->smarty->fetch('templates/common/modules/'.$tpl.'.tpl', null, $this->language);
		}

	}
	
}
?>