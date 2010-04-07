<?php

class Admin {
    private $modules = array();
    private $modulesPath = '/admin/modules/';

    private $db;
    private $smarty;
    private $user;
    private $lang;

    function __construct() {
        $this->db = ObjectRegistry::getInstance()->get('db');
        $this->smarty = ObjectRegistry::getInstance()->get('smarty');
        $this->user = ObjectRegistry::getInstance()->get('user');
        $this->lang = $this->user->get('EditLang');
        $this->getModules();

        if (isset($_POST['login']) && isset($_POST['password'])){
            $this->user->login($_POST['login'], $_POST['password']);
        }
    }

    function getModules() {
        $sql = $this->db->Prepare("SELECT * FROM " . DB_PREFIX . "modules WHERE Active='1' ORDER BY ModGroup DESC, ID ASC");
        $res = $this->db->Execute($sql);
        if ($res && $res->RecordCount() > 0) {
            $this->modules = $res->getArray();
        }

        return $this->modules;
    }

    function setTemplateVars() {
        $this->smarty->assign("modules", $this->modules);
        $this->smarty->assign("langList", LanguageService::getInstance()->getAll());
        $this->smarty->assign("user", User::getInstance()->getData());
    }


    function loadModule(){
        $moduleVarName = Settings::get('modules_varname');
        $module = $_GET[$moduleVarName];
        $modulePath = $_SERVER['DOCUMENT_ROOT'].$this->modulesPath.'/'. $module . "/module.php";
        if (isset($module) && in_array($module, $this->modules) && file_exists($modulePath)) {
            if (Access::check($module, 'show')) {
                include_once($modulePath);
            }
        } else {
            $data = $this->smarty->fetch('admin/dashboard.tpl', null, $this->lang);
        }
        $this->smarty->assign('CONTENT', $data);
    }

    function getBody() {
        $template = 'login.tpl';

        if ($this->user->isAuth()){
            $template = 'admin.tpl';
            $this->loadModule();
        }

        return $this->smarty->fetch($template, null, $this->lang);
    }

    function display() {
        $this->setTemplateVars();
        $this->smarty->assign("BODY", $this->getBody());
        $this->smarty->display('index.tpl', null, $this->lang);
    }
}

?>
