<?
include_once($_SERVER['DOCUMENT_ROOT']."/admin/modules/permissions/modules.php");
include_once($_SERVER['DOCUMENT_ROOT']."/admin/modules/permissions/groups.php");
include_once($_SERVER['DOCUMENT_ROOT']."/admin/modules/permissions/users.php");

$parse_main = $smarty->fetch('permissions/permissions.tpl', null, $language);

$xajax->registerFunction("show_users");
$xajax->registerFunction("show_user_rights");
$xajax->registerFunction("rights_change");


function show_users($group_id,$check,$module_id){
global $db,$smarty,$language,$lang;

  $objResponse = new xajaxResponse();
  
  if ($check=="true" && $group_id!=""){
    $sql = $db->prepare("SELECT * FROM ".DB_PREFIX."users WHERE GroupID='".$group_id."' ORDER BY Name ASC");
    $res = $db->execute($sql);
    if ($res && $res->RecordCount() > 0){
      $sql2 = $db->prepare("SELECT Name FROM ".DB_PREFIX."groups WHERE ID='".$group_id."'");
      $res2 = $db->execute($sql2);
      if ($res2 && $res2->RecordCount()){
        $smarty->assign("info",$lang["per_group"].":".$res2->fields["Name"]); 
      }
      $sql2 = $db->prepare("SELECT * FROM ".DB_PREFIX."modules_rights WHERE GroupID='".$group_id."' AND ModuleId='".$module_id."'");
      $res2 = $db->execute($sql2);
      if ($res2 && $res2->RecordCount()){
        $smarty->assign("IsShow",$res2->fields["IsShow"]);
        $smarty->assign("IsAdd",$res2->fields["IsAdd"]);
        $smarty->assign("IsChange",$res2->fields["IsChange"]);
        $smarty->assign("IsDelete",$res2->fields["IsDelete"]);
        $smarty->assign("IsPublish",$res2->fields["IsPublish"]);
      }
        $smarty->assign("users",$res->GetArray());
    }
    
    $smarty->assign("moduleid",$module_id);
    $smarty->assign("groupid",$group_id);
    
    $form = $smarty->fetch('permissions/rights/add.tpl', null, $language);
    $objResponse->addAssign('perm_area', "innerHTML",$form);
    
  } else {
    $smarty->assign("users",array());
  }
  $table = $smarty->fetch('permissions/users/users.tpl', null, $language);
  $objResponse->addAssign('permission_users', "innerHTML", $table);
  $objResponse->addScript("initTableWidget('myTable','270','300',Array(false,'S'));");
  #$objResponse->addAssign('perm_area', "innerHTML", "");

  return $objResponse->getXML();
    
}

function show_user_rights($module_id,$group_id,$user_id){
global $db,$smarty,$language,$lang; 
  $objResponse = new xajaxResponse();
  
  $sql = $db->prepare("SELECT Name, Familyname FROM ".DB_PREFIX."users WHERE ID='".$user_id."'");
    $res = $db->execute($sql);
    if ($res && $res->RecordCount() > 0){
      $smarty->assign("info",$lang["per_user"].":".$res->fields["Name"]." ".$res->fields["Familyname"]);
    }
    
  $sql2 = $db->prepare("SELECT * FROM ".DB_PREFIX."modules_rights WHERE UserID='".$user_id."' AND ModuleId='".$module_id."'");
  $res2 = $db->execute($sql2);
  if ($res2 && $res2->RecordCount()){
    $smarty->assign("IsShow",$res2->fields["IsShow"]);
    $smarty->assign("IsAdd",$res2->fields["IsAdd"]);
    $smarty->assign("IsChange",$res2->fields["IsChange"]);
    $smarty->assign("IsDelete",$res2->fields["IsDelete"]);
    $smarty->assign("IsPublish",$res2->fields["IsPublish"]);
  }
  
  $smarty->assign("moduleid",$module_id);
    $smarty->assign("groupid",$group_id);
    $smarty->assign("userid",$user_id);
  
  $form = $smarty->fetch('permissions/rights/add.tpl', null, $language);
    $objResponse->addAssign('perm_area', "innerHTML",$form);

    return $objResponse->getXML();
}

function rights_change($data){
global $db,$lang; 
  $objResponse = new xajaxResponse();
  if (check_rights("change")){
    isset($data["isshow"]) ? $isshow = $data["isshow"] : $isshow = "0";
    isset($data["isadd"]) ? $isadd = $data["isadd"] : $isadd = "0";
    isset($data["ischange"]) ? $ischange = $data["ischange"] : $ischange = "0";
    isset($data["isdelete"]) ? $isdelete = $data["isdelete"] : $isdelete = "0";
    isset($data["ispublish"]) ? $ispublish = $data["ispublish"] : $ispublish = "0";
  
    if ($data["moduleid"]!="" && $data["groupid"]!=""){
      $sql = $db->prepare("SELECT ID FROM ".DB_PREFIX."modules_rights WHERE ModuleID='".$data["moduleid"]."' AND GroupID='".$data["groupid"]."'");
      $res = $db->execute($sql);
      if ($res && $res->RecordCount() > 0){
        $rsql = "UPDATE ".DB_PREFIX."modules_rights SET IsShow='".$isshow."', IsAdd='".$isadd."', IsChange='".$ischange."', IsDelete='".$isdelete."', IsPublish='".$ispublish."' WHERE ID='".$res->fields["ID"]."'";
      } else {
        $rsql = "INSERT INTO ".DB_PREFIX."modules_rights (ModuleID,GroupID,IsAdd,IsChange,IsDelete,IsPublish) VALUES ('".$data["moduleid"]."','".$data["groupid"]."','".$isadd."','".$ischange."','".$isdelete."','".$ispublish."')";
      }
    }
    
    if ($data["moduleid"]!="" && $data["userid"]){
      $sql = $db->prepare("SELECT ID FROM ".DB_PREFIX."modules_rights WHERE ModuleID='".$data["moduleid"]."' AND UserID='".$data["userid"]."'");
      $res = $db->execute($sql);
      if ($res && $res->RecordCount() > 0){
        $rsql = "UPDATE ".DB_PREFIX."modules_rights SET IsShow='".$isshow."', IsAdd='".$isadd."', IsChange='".$ischange."', IsDelete='".$isdelete."', IsPublish='".$ispublish."' WHERE ID='".$res->fields["ID"]."'";
      } else {
        $rsql = "INSERT INTO ".DB_PREFIX."modules_rights (ModuleID,UserID,IsAdd,IsChange,IsDelete,IsPublish) VALUES ('".$data["moduleid"]."','".$data["userid"]."','".$isadd."','".$ischange."','".$isdelete."','".$ispublish."')";
      }
    }
    $sql = $db->prepare($rsql);
    $res = $db->execute($sql);
    if ($res){
      $objResponse->addAlert($lang["per_change_suc"]);
    } else $objResponse->addAlert($lang["per_change_err"]);
  } else $objResponse->addAlert($lang["per_cant_change"]);
  
  $objResponse->addAssign("perm_area","innerHTML","");
  
  
  return $objResponse->getXML();
}
?>