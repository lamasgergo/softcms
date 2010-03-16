<?
/* define menu*/
$smarty->assign("mod","groups");
$smarty->assign("groups_menu",$smarty->fetch("manage/groups/menu.tpl",null,$language));


$sql = $db->prepare("SELECT * FROM ".DB_PREFIX."groups ORDER BY Name ASC");
$res = $db->execute($sql);
if ($res && $res->RecordCount() > 0){
  $smarty->assign("groups",$res->GetArray());
}

$smarty->assign("GROUPS",$smarty->fetch('manage/groups/groups.tpl', null, $language));

$xajax->registerFunction("show_form_groups");
$xajax->registerFunction("groups_add");
$xajax->registerFunction("groups_change");
$xajax->registerFunction("groups_delete");
$xajax->registerFunction("refresh_groups");
$xajax->registerFunction("publish_groups");


function refresh_groups(){
  global $db,$smarty,$language;
  $sql = $db->prepare("SELECT * FROM ".DB_PREFIX."groups ORDER BY Name ASC");
  $res = $db->execute($sql);
  if ($res && $res->RecordCount() > 0){
    $smarty->assign("groups",$res->GetArray());
  }
  $table = $smarty->fetch('manage/groups/table.tpl', null, $language);
  $objResponse = new xajaxResponse();
  $objResponse->addAssign('visual_groups', "innerHTML", $table);
  $objResponse->addScript("initTableWidget('myTable','100%','480',Array(false,'S'));");
  $objResponse->addAssign('dynamic', "innerHTML", "");
  return $objResponse;
}

function show_form_groups($form,$id=""){
  global $smarty,$language,$db,$lang;

  $objResponse = new xajaxResponse();
  if (check_rights($form)){
    if (isset($id) && !empty($id)){
      $sql = $db->prepare("SELECT ID,Name FROM ".DB_PREFIX."groups WHERE ID='".$id."'");
      $res = $db->Execute($sql);
      if ($res && $res->RecordCount() > 0){
        $smarty->assign("id",$res->fields["ID"]);
        $smarty->assign("name",$res->fields["Name"]);
      }
    }
    $file = $smarty->fetch('manage/groups/'.$form.'.tpl',null,$language);
    $objResponse->addScriptCall("deleteTab",false,2,'dhtmlgoodies_tabView1');
    $objResponse->addScriptCall("createNewTab","dhtmlgoodies_tabView1",$lang["groups_".$form],$file,'');
  }  else $objResponse->addAlert($lang["per_cant_".$form]);

  return $objResponse->getXML();
}

function groups_add($data){
  global $db,$lang;

  $objResponse = new xajaxResponse();

  if ($data["name"]!=""){
    $chsql = $db->prepare("SELECT ID FROM ".DB_PREFIX."groups WHERE Name='".$data["name"]."'");
    $chres = $db->Execute($chsql);
    if ($chres && $chres->RecordCount() > 0){
      $objResponse->addAlert($lang["groups_name_exist"]);
    } else {
      $sql = $db->prepare("INSERT INTO ".DB_PREFIX."groups(Name) VALUES('".$data["name"]."')");
      $res = $db->Execute($sql);

      if ($res){
        $objResponse->addScript("xajax_refresh_groups();");
        $objResponse->addAlert($lang["groups_add_suc"]);
        $objResponse->addScriptCall("deleteTab",false,2,'dhtmlgoodies_tabView1');
        $objResponse->addScriptCall("showTab",'dhtmlgoodies_tabView1',0);
      } else {
        $objResponse->addAssign('dynamic', "innerHTML",$sql);
      }
    }
  } else $objResponse->addAlert($lang["groups_caption_absent"]);
  return $objResponse->getXML();
}

function groups_change($data){
  global $db,$lang;

  $objResponse = new xajaxResponse();

  if ($data["name"]!=""){
    $sql = $db->prepare("UPDATE ".DB_PREFIX."groups SET Name = '".$data["name"]."' WHERE ID='".$data["id"]."'");
    $res = $db->Execute($sql);

    if ($res){
        $objResponse->addAlert($lang["groups_change_suc"]);
        $objResponse->addScript("xajax_refresh_groups();");
        $objResponse->addScriptCall("deleteTab",false,2,'dhtmlgoodies_tabView1');
        $objResponse->addScriptCall("showTab",'dhtmlgoodies_tabView1',0);
    } else {
      $objResponse->addAssign('dynamic', "innerHTML",$sql);
    }
  } else $objResponse->addAlert($lang["groups_caption_absent"]);
  return $objResponse->getXML();
}

function groups_delete($data){
  global $db,$lang;

  $objResponse = new xajaxResponse();
  
  if (check_rights('delete')){
    if ($data["id"]!=""){
      $sql = $db->prepare("SELECT g.Name as GroupName, count(u.ID) as users FROM ".DB_PREFIX."groups as g LEFT JOIN ".DB_PREFIX."users as u ON (u.GroupID=g.ID) WHERE g.ID='".$data["id"]."' GROUP BY g.Name");
      $res = $db->Execute($sql);
      if ($res && $res->RecordCount() > 0){
        if ($res->fields["GroupName"]!="admin"){
          if ($res->fields["users"]!="0"){
            $objResponse->addAlert($lang["before_delete_users_from_group"]." : ".$res->fields["GroupName"]." (".$res->fields["users"].")");
          } else {
            $sql2 = $db->prepare("DELETE FROM ".DB_PREFIX."groups WHERE ID='".$data["ID"]."'");
            $res2 = $db->Execute($sql2);
            if ($res2){
              $objResponse = refresh_groups();
              $objResponse->addAlert($lang["groups_delete_suc"]);
            } else {
              $objResponse->addAssign('dynamic', "innerHTML",$sql2);
            }
          }
        } else $objResponse->addAlert($lang["groups_admin_cant_be_deleted"]);
      }
    } else $objResponse->addAlert($lang["check_items_for_deleting"]);
  } else $objResponse->addAlert($lang["per_cant_delete"]);

  return $objResponse->getXML();
}
?>
