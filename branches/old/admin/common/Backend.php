<?php
class Backend{
	
	var $objects = array();
	var $module = '';
	
	function Backend($module){
		global $smarty,$language,$lang;
		$this->name = $name;
		$this->smarty = $smarty;
		$this->language = $language;
		$this->lang = $lang;
		$this->module = $module;
	}
	
	function addObject($obj, $index=0){
		if ($index==0) $index = count($this->objects)+1;
		$this->objects[$index] = array(
								"name" => $obj->getName(),
								"menu" => $obj->getMenu(),
								"data" => $obj->show(),
							);
	}
	
	function show(){
		$this->smarty->assign('module', $this->module);
		$this->smarty->assign('objects', $this->objects);
		return $this->smarty->fetch('templates/common/backend.tpl', null, $this->language);
	}
}
?>