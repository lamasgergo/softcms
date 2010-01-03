<?php

class AdminLocale{

	var $language;
	var $db;
	var $lang;
	
	function __construct(){
		global $db, $user;
		$this->language = $this->user['GUILanguage'];
		$this->loadCommon();
		$this->loadModules();
	}

	function loadCommon(){
		$path = $_SERVER['DOCUMENT_ROOT'].'/shared/locale/'.$this->language.'/common.php';
		if (file_exists($path)){
			include_once($path);
			$this->lang = $lang;
			unset($lang);
		}
	}
	
	function loadModules(){
		$sql = $db->prepare("SELECT * FROM ".DB_PREFIX."modules WHERE Active='1' ORDER BY Name ASC");
		$res = $db->execute($sql);
		if ($res && $res->RecordCount() > 0){
			while (!$res->EOF){
				$this->loadModule($res->fields['Name']);
				$res->MoveNext();
			}
		} 
	}
	
	function loadModule($module){
		$path = $_SERVER['DOCUMENT_ROOT'].'/admin/modules/'.$module.'/locale/'.$this->language.'.php';
		
		if (file_exists($path)){
			include_once($path);
			$this->lang = $lang;
			unset($lang);
		}
	}
	
	function getLang(){
		return $this->lang;
	}
}
?>