<?php

class Admin {
    private $modules = array();
    private $modulesData = array();
    private $modulesPath = '/admin/modules/';

    private $db;
    private $smarty;
    private $user;
    private $lang;
    private $error;

    function __construct() {
        global $db, $smarty, $debugInfo;
        $this->db = $db;
        $this->smarty = $smarty;
        $this->user = User::getInstance();
        $this->lang = $this->user->get('EditLang');
        $this->getModules();

        if (isset($_POST['login']) && isset($_POST['password'])){
            if (!$this->user->login($_POST['login'], $_POST['password'])){
                $this->error = Locale::get("login_failed", 'ADMIN');
            } else {
                header('Location: '.$_SERVER['REQUEST_URI']);
            }
        }
    }

    function getModules() {
        $sql = $this->db->Prepare("SELECT * FROM " . DB_PREFIX . "modules WHERE Active='1' ORDER BY ModGroup DESC, ID ASC");
        $res = $this->db->Execute($sql);
        if ($res && $res->RecordCount() > 0) {
            $this->modulesData = $res->getArray();
            foreach ($this->modulesData as $data){
                $this->modules[] = $data['Name'];
            }
        }

        return $this->modules;
    }

    function setTemplateVars() {
        $this->smarty->assign("error", $this->error);
        $this->smarty->assign("modules", $this->modulesData);
        $this->smarty->assign("langList", LanguageService::getInstance()->getAll());
        $this->smarty->assign("user", User::getInstance()->getData());
    }


    function loadModule(){
        $moduleVarName = Settings::get('modules_varname');
        $module = 'dashboard';
        if (isset($_GET[$moduleVarName]) && !empty($_GET[$moduleVarName])){
            $module = $_GET[$moduleVarName];
        }

        $modulePath = $_SERVER['DOCUMENT_ROOT'].$this->modulesPath.'/'. $module . "/module.php";
        if (isset($module) && in_array($module, $this->modules) && file_exists($modulePath)) {
            if (Access::check($module, 'show')) {
                include_once($modulePath);
                $data = TabView::show();
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
