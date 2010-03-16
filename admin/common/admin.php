<?php

$smarty->assign("modules", getModules());
$smarty->assign("langList", $langService->getLanguagesList());
$smarty->assign("user",$user->data);


if (isset($_GET[MODULE]) && file_exists(__PATH__."/admin/modules/".$_GET[MODULE]."/".$_GET[MODULE].".php")){
  if (check_show_rights()){
    include_once(__PATH__."/admin/modules/".$_GET[MODULE]."/".$_GET[MODULE].".php");
  }
} else {
    $smarty->assign('BODY', $smarty->fetch('admin/dashboard.tpl', null, $language));
}
$smarty->assign("BODY",$parse_main);
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
