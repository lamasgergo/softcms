<?php

class AdminPage extends base{

	var $url = '/';
    var $tpl = 'templates/admin.tpl';
    var $_moduleVarName = 'mod'; 
    var $user;
    var $lang;
    var $xajax;

	function AdminPage($module=null){
        global $user, $lang, $xajax, $smarty;
        parent::base();

        $this->user = $user;
        $this->lang = $lang;
        $this->xajax = &$xajax;
        $this->smarty = &$smarty;
        $this->language = $lang->getLanguage();

        $this->smarty->template_dir = $_SERVER['DOCUMENT_ROOT'].'/admin/';

	}



    function getModule($moduleName){
		$component = '';
		if (strpos($moduleName,'|')){
			list($moduleName, $component) = explode("|", $moduleName);
		}
        return $_SERVER['DOCUMENT_ROOT'].'/admin/modules/'.$moduleName.'/'.(!empty($component) ? $component : $moduleName).'.php';
    }

    function isModuleCall(){
        return (isset($_GET[$this->_moduleVarName]) && !empty($_GET[$this->_moduleVarName]));
    }

    function getContent($name){
        $result = '';
        if (file_exists($this->getModule($name))){
            include_once($this->getModule($name));
        }
        if (class_exists($name)){
            $class = new $name();
            if (method_exists($class, 'output')){
                $result = $class->output();
            }
        }
        if (empty($result)){
            $result = $parse_main;
            unset($parse_main);
        }
        return $result;
    }

    function dashboard(){
        $sql = $this->db->prepare("SELECT ModGroup FROM ".DB_PREFIX."modules WHERE Active='1' GROUP BY ModGroup ORDER BY ID ASC");
        $res = $this->db->Execute($sql);
        $modules_groups = $res->getArray();
        $res->MoveFirst();
        $modules = array();
        if ($res && $res->RecordCount() > 0){
            while (!$res->EOF){
                $sql2 = $this->db->prepare("SELECT * FROM ".DB_PREFIX."modules WHERE ModGroup='".$res->fields["ModGroup"]."' AND Active='1' ORDER BY Name ASC");
                $res2 = $this->db->execute($sql2);
                if ($res2 && $res2->RecordCount() > 0){
                    $data = $res2->GetArray();
                    $modules[] = $data;
                }
                $res->MoveNext();

            }
        }


        $parse_main = $this->smarty->assign('modules_groups', $modules_groups);

        $this->smarty->assign("modules",$modules);
        return $this->smarty->fetch('templates/dashboard/dashboard.tpl', null, $this->language);
    }


	function runAjax($module){
		if (file_exists($this->getModule($module))){
            include_once($this->getModule($module));
        }
		
		list($module, $name) = explode("|", $module);
		
		$_GET[MODULE] = $module;
		
		$result = '';
        if (class_exists($name)){
            $class = new $name($module);
            if (method_exists($class, 'show')){
                $result = $class->show();
            }
        }
        
		$this->smarty->assign("BODY", $result);
		$this->tpl = 'templates/ajax.tpl';
		$this->smarty->display($this->tpl,null,$this->language);
	}
	
    function display(){
        if ($this->user->is_auth()){
            $module = $_GET[$this->_moduleVarName];
			if (strpos($module,'|')) return $this->runAjax($module);
            $data = '';
            if ($this->isModuleCall() && Access::check($module)){
                $data = $this->getContent($module);
            } else {
                $data = $this->dashboard();
            }
            $this->smarty->assign("GUILang",$this->user->data['GUILang']);
            $this->smarty->assign("ContentLang",$this->user->data['ContentLang']);
            $this->smarty->assign("BODY",$data);
        } else {
            $this->tpl = 'templates/login/login.tpl';
        }

        $this->xajax->processRequests();
        $this->smarty->assign("xajax_js",$this->xajax->getJavascript("/shared/js/xajax/","xajax.js"));

        $this->smarty->display($this->tpl,null,$this->language);
    }
}
?>
