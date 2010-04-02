<?php

$smarty->assign("modules", getModules());
$smarty->assign("langList", $langService->getLanguagesList());
$smarty->assign("user", User::getInstance()->getData());

$module = $_GET['mod'];
$parse_main = '';

$module_path = realpath(dirname(__FILE__)."/../modules/".$module."/module.php");
if (isset($module) && file_exists($module_path)){
  if (Access::check($module, 'show')){
    include_once($module_path);
  }
} else {
    $parse_main = $smarty->fetch('admin/dashboard.tpl', null, $language);
}
$smarty->assign("BODY", $parse_main);
$smarty->display('admin.tpl', null, $language);




function getModules(){
    global $db;
    $modules = array();
    $sql = $db->prepare("SELECT * FROM ".DB_PREFIX."modules WHERE Active='1' ORDER BY ModGroup DESC, ID ASC");
    $res = $db->execute($sql);
    if ($res && $res->RecordCount() > 0){
        $modules = $res->getArray();
    }
                   
    return $modules;
}

?>
