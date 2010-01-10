<?php
class BackendElement{

    var $gridFields = '';

    var $gridAlwaysHideItems = 'UserID, LangID';

    var $gridHideItems = '';

    var $locale;

    var $langID;

    var $contentLang;

    var $user;

    var $db;

    var $xajax;

    var $module;

    var $id;

    var $defaultAction = 'grid';

    var $actions = array('add','change', 'delete', 'publish');

    var $langDepended = false;

    var $requiredFields = '';

    var $autoFillFields = array();

    var $debug = true;

    function BackendElement(){
        global $smarty, $user, $db, $xajax, $locale;

        $this->locale = $locale;
        $this->locale->loadBackendModuleLocale($this->module);


        $this->user = $user;
        $this->db = $db;
        $this->smarty = &$smarty;
        $this->xajax = &$xajax;

        $this->language = $this->user->data['GUILang'];
        $this->contentLang = $this->user->data['ContentLang'];


        $this->qb = new QueryBuilder($this->table);

        if ($this->langDepended){
            $this->qb->setLang($this->contentLang);
        }

        $this->autoFillFields = array(
            "Created" => "NOW()",
            "UserID" =>    $this->user->id
        );

        $this->qb->setAutoFillFields($this->autoFillFields);

        foreach ($this->actions as $action){
            $this->xajax->registerFunction(array($this->getName()."_".$action,$this,$this->getName()."_".$action));
        }
    }

    function getLang(){
        return $this->contentLang;
    }

    function getGridFields(){
        if (empty($this->gridFields)){
            $this->gridFields = $this->qb->columnsNames;

            $this->gridAlwaysHideItems = preg_replace("/\s*/","", $this->gridAlwaysHideItems);
            $hide = explode(",",$this->gridAlwaysHideItems);
            $this->gridFields = array_diff($this->gridFields, $hide);

            $this->gridHideItems = preg_replace("/\s*/","", $this->gridHideItems);
            $hide = explode(",",$this->gridHideItems);
            $this->gridFields = array_diff($this->gridFields, $hide);
        } else {
            $this->gridFields = explode(",", $this->gridFields);
        }
        return $this->gridFields;
    }

    function getName(){
        return $this->name;
    }

    function getMenu(){
        $this->smarty->assign("module", $this->module);
        $this->smarty->assign("component", $this->getName());
        if (file_exists($this->smarty->template_dir.'/modules/'.strtolower($this->module).'/templates/'.strtolower($this->name).'/menu.tpl')){
            return $this->smarty->fetch(strtolower($this->module).'/templates/'.strtolower($this->name).'/menu.tpl', null, $this->language);

        } else {
            return $this->smarty->fetch('templates/common/modules/menu.tpl', null, $this->language);
        }
    }


    function output($tpl){
        if (file_exists($this->smarty->template_dir.'/modules/'.strtolower($this->module).'/templates/'.strtolower($this->name).'/'.$tpl.'.tpl')){
            return $this->smarty->fetch('modules/'.strtolower($this->module).'/templates/'.strtolower($this->name).'/'.$tpl.'.tpl', null, $this->language);
        } else {
            return $this->smarty->fetch('templates/common/modules/'.$tpl.'.tpl', null, $this->language);
        }
    }

    function getGridData(){
        $data = $this->qb->makeSelect();
        return $data;
    }

    function showGrid(){
        $this->smarty->assign("columns", $this->getGridFields());
        $this->smarty->assign("module", $this->getName());
        $this->smarty->assign("items_arr", $this->getGridData());
        return $this->output('table');
    }

    function prepareModifyForm(){
    }

    function showModifyForm($id=''){

        $this->prepareModifyForm();

        $id = intval($id);
        if ($id && !empty($id)){
            $this->qb->setFilter('ID',$id);
            list($data) = $this->qb->makeSelect();

            $this->smarty->assign('data', $data);
            $this->smarty->assign('form', 'change');
        } else {
            $this->smarty->assign('form', 'add');
        }

        $this->smarty->assign('module', $this->module);
        $this->smarty->assign('component', $this->getName());

        return $this->output('form');
    }

    function checkRequiredFields($data=array()){
        if (empty($this->requiredFields)) return true;
        if (!is_array($this->requiredFields)){
            $this->requiredFields = preg_replace("/\s*/","", $this->requiredFields);
            $this->requiredFields = explode(",", $this->requiredFields);
        }
        if (count($data)==0){
            if (count($this->data)==0) return false;
            $data = $this->data;
        }

        $required = array();

        foreach ($this->requiredFields as $key){
            if (isset($data[$key])){
                if (is_numeric($data[$key]) && $data[$key]==0){
                    $required[] = $key;
                }
                if (is_string($data[$key]) && $data[$key]==''){
                    $required[] = $key;
                }
            } else {
                $required[] = $key;
            }
        }

        if (count($required)>0){
            return array(false, $required);
        } else {
            return array(true, array());
        }

    }


    function getActions(){
        if (isset($_GET[ACTION_URL]) && !empty($_GET[ACTION_URL])){
            if (in_array($_GET[ACTION_URL], $this->actions)){
                $this->id = $_GET['id'];
                return $_GET[ACTION_URL];
            }
        }

        return $this->defaultAction;
    }

    function show(){
        $result = '';
        switch ($this->getActions()){
            case "grid":
                $result = $this->showGrid();
                break;
            case "add":
                $result = $this->showModifyForm();
                break;
            case "change":
                $result = $this->showModifyForm($this->id);
                break;
            case "delete":
                $result = $this->showGrid();
                break;
        }
        return $result;
    }

    function runAjaxAction($action, $data, $check_data=true, $closeTab=true){
        $action = strtolower($action);
        $resp = new XajaxResponse();
        list ($continue, $empty_fields) = $this->checkRequiredFields($data);
        if ($continue){
            switch ($action){
                case 'add':
                    $query = $this->qb->makeInsert($data);
                    break;
                case 'change':
                    $query = $this->qb->makeUpdate($data);
                    break;
                case 'delete':
                    $query = $this->qb->makeDelete($data);
                    break;
            }

            $query = $this->db->prepare($query);
            $res = $this->db->Execute($query);
            if ($res){
                $resp->addAlert($this->translate($this->module.'_'.$this->getName().'_'.$action.'_true'));
				$resp->addAlert((bool)$closeTab);
                $resp->addScriptCall($action.'FormCallback', $this->module, $this->getName(), (bool)$closeTab);
                
            } else {
                $resp->addAlert($this->translate($this->module.'_'.$this->getName().'_'.$action.'_false'));
                if ($this->debug){
                    //$resp->addAlert($query);
                    $resp->addScriptCall("showDebug", $query);
                }
            }
        } else {
            $resp->addAlert($this->translate('requered_data_absent'));
            if ($this->debug){
                //$resp->addAlert(print_r($empty_fields, 1));
                $resp->addScriptCall("showDebug", print_r($empty_fields, 1));
            }
        }
        return $resp->getXML();
    }

    function translate($data){
		return $this->locale->translate($data);
    }

    function getFilter(){
        return $this->output('filter');
    }

}

?>