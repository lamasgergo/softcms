<?php


$xajax->registerFunction("check_rights");

/* menu */
include_once($_SERVER['DOCUMENT_ROOT']."/admin/common/menu.php");

define("MODULE", $page->_moduleVarName);



if (isset($_GET[MODULE]) && file_exists($_SERVER['DOCUMENT_ROOT']."/admin/modules/".$_GET[MODULE]."/".$_GET[MODULE].".php")){
    if (check_show_rights()){
        include_once($_SERVER['DOCUMENT_ROOT']."/admin/modules/".$_GET[MODULE]."/".$_GET[MODULE].".php");
    } else {
        include_once($_SERVER['DOCUMENT_ROOT']."/admin/common/dashboard.php");
    }
} else {
    /* admin mainpage*/
    include_once($_SERVER['DOCUMENT_ROOT']."/admin/common/dashboard.php");
}


$smarty->assign("MENU",$parse_menu);
$smarty->assign("BODY",$parse_main);


$xajax->processRequests();
$smarty->assign("xajax_js",$xajax->getJavascript("/shared/js/xajax/","xajax.js"));

$smarty->display('templates/admin.tpl', null, $language);


function check_show_rights(){
  global $lang,$user,$db;
  $ret = true;
  $module = $_GET[MODULE];
  if (!$user->admin){
    $sql = $db->prepare("SELECT r.IsShow as IsShow FROM ".DB_PREFIX."modules_rights as r LEFT JOIN ".DB_PREFIX."modules as m ON (m.ID=r.ModuleID) WHERE r.UserID='".$user->id."'  AND m.Link='".$module."' GROUP BY r.ModuleID");
    $res = $db->Execute($sql);
    if ($res && $res->RecordCount() > 0){
      if ($res->fields["IsShow"]=="0") $ret = false;
    } else {
      $sql = $db->prepare("SELECT r.IsShow as IsShow FROM ".DB_PREFIX."modules_rights as r LEFT JOIN ".DB_PREFIX."modules as m ON (m.ID=r.ModuleID) WHERE r.GroupID='".$user->group_id."' AND m.Link='".$module."' GROUP BY r.ModuleID");
      $res = $db->Execute($sql);
      if ($res && $res->RecordCount() > 0){
        if ($res->fields["IsShow"]=="0") $ret = false;
      }
    }
  } else $ret = true;
  if ($ret==false) echo "<script language='Javascript'>alert('".$lang["per_cant_show"]."');</script>";
  return $ret;
}


function check_rights($action){
  global $lang,$user,$db;
  $ret = false;
  $module = $_GET[MODULE];
  $action = ucfirst($action);

  if (!$user->admin){
    $sql = $db->prepare("SELECT r.Is".$action." as Perm FROM ".DB_PREFIX."modules_rights as r LEFT JOIN ".DB_PREFIX."modules as m ON (m.ID=r.ModuleID) WHERE r.UserID='".$user->id."' AND m.Link='".$module."' GROUP BY r.ModuleID");
    $res = $db->Execute($sql);
    if ($res && $res->RecordCount() > 0){
      if ($res->fields["Perm"]=="1") $ret = true;
    } else {
      $sql = $db->prepare("SELECT r.Is".$action." as Perm FROM ".DB_PREFIX."modules_rights as r LEFT JOIN ".DB_PREFIX."modules as m ON (m.ID=r.ModuleID) WHERE r.GroupID='".$user->group_id."' AND m.Link='".$module."' GROUP BY r.ModuleID");
      $res = $db->Execute($sql);
      if ($res && $res->RecordCount() > 0){
        if ($res->fields["Perm"]=="1") $ret = true;
      }
    }
  } else{
    $ret = true;
  }
  return $ret;
}


?>
