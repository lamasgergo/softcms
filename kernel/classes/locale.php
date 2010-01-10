<?php

class Locale extends languages{

    var $locale = array();

    var $localeStorePath = '/shared/locale/';

    var $localeDefaultNames = array('common', 'errors', 'site');

    var $db;

    var $module;

    function Locale(){
        global $db;
        parent::languages();
        $this->db = $db;
    }

    function loadLocale($module){
        $path = $_SERVER['DOCUMENT_ROOT'].'/'.$this->localeStorePath.'/'.$this->getLanguage().'/'.$module.'.php';
        if (file_exists($path)){
            include_once($path);
            if (count($this->locale) == 0){
                $this->locale = $lang;
            } else {
                array_push($this->locale, $lang);
            }
            unset($lang);
        }
    }

    function localeDefaults(){
        $this->locale = array();
        foreach ($this->localeDefaultNames as $localeFileName){
            $this->loadLocale($localeFileName);
        }
    }

    function getLocale(){
        return $this->locale;
    }


	function loadBackendLocale(){
		$sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."modules WHERE Active='1' ORDER BY Name ASC");
		$res = $this->db->execute($sql);
		if ($res && $res->RecordCount() > 0){
			while (!$res->EOF){
				$this->loadBackendModuleLocale($res->fields['Name']);
				$res->MoveNext();
			}
		}
	}

	function loadBackendModuleLocale($module){
		$path = $_SERVER['DOCUMENT_ROOT'].'/admin/modules/'.$module.'/locale/'.$this->_current.'.php';
		if (file_exists($path)){
			include_once($path);
			$this->locale = array_merge($this->locale, $lang);
			unset($lang);
		}
	}

    function setModule($module){
        $this->module = $module;
    }

	function translate($name){
        $name = trim($name);
        if (isset($this->locale[$this->module]) && (isset($this->locale[$this->module][$name]) && !empty($this->locale[$this->module][$name]))){
            echo $name.":".$this->module.":".$this->locale[$this->module][$name]."<br>";
            return $this->locale[$this->module][$name];
        }
        if (isset($this->locale[$name]) && !empty($this->locale[$name])){
            return $this->locale[$name];
        }
        return $name;
    }
}

$locale = new Locale();
$locale->localeDefaults();
$locale->setModule($_GET['mod']);
?>