<?php
require_once(__PATH__.'/admin/common/WidgetElement.php');
class AdminWidget{
/* Name of a Tab Element */
	var $name;

	/* Body of a Tab Element */
	var $value;

	/* Action menu for Tab Element */
	var $menu;

	/* Data Filter for Tab Element */
	var $filter;

	/* Name of a DIV where Tab Element will parsed */
	var $visual_div_name;

	/* ADODB object */
	var $db;

	/* xAjax object */
	var $xajax;

	/* array of xajax functions names*/
	var $xajax_functions = array();

	/* Smarty object */
	var $smarty;

	/* Lang array with localization vars */
	var $lang;

	/* Var with lang ID for smarty templates engine */
	var $language;

	/* Main module name */
	var $mod_name;

	/* JS sortable params:
	 * false 	: don't sort
	 * 'S'		: string sorting
	 * 'N'		: numeric sorting
	 * 
	 * example: false,'S','N',false,'S','S'
	*/
	var $sort_table_fields;
	
	/* root path for templates*/
	var $tpl_path;
	/* root path for module templates*/
	var $tpl_module_path;
	
	/* ID of the class (tab ID) */
	var $counter = 0;
	var $tabID;
	
	/* Upload directory */
	var $uploadDirectory;
	/* Relative path to images dir */
	var $relativePath;
	
	/* user ID*/
	var $user;
	
	
	function AdminWidget($name){
		global $smarty,$language,$lang,$xajax,$db,$user;
		$this->user = $user;
		$this->visual_div_name = "widget_".$this->getName();
		$this->smarty = &$smarty;
		$this->xajax = &$xajax;
		//set existing objects
		$this->db = &$db;
		$this->lang = $lang;
		$this->language = $language;
		//set common module name
		$this->mod_name = $name;
		//set path to tab module templates
		$this->tpl_module_path = strtolower($this->mod_name);
		// set directory for image upload
		$this->uploadDirectory = uploadDirectory.'/gallery/';
		// set url to uploaded images
		$this->relativePath = uploadDirectoryURL;
		// set ajax functions
		$this->setAjaxVars();
	}
	
	// register ajax functions
	function setAjaxVars(){
		foreach ($this->xajax_functions as $func_name){
			$this->xajax->registerFunction(array($func_name,$this,$func_name));
		}
	}
	
	function addXajaxFunction($name){
		$this->xajax_functions[] = $name;	
	}
	
	function getWidgetContent(){
	}
	
	function show(){
		$this->getWidgetContent();
		return $this->smarty->fetch($this->name.'/main.tpl', null, $this->language);
	}
	
}
?>