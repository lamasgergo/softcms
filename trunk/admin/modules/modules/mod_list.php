<?
/* define menu*/
$smarty->assign("mod","mod_list");
$smarty->assign("mod_list_menu",$smarty->fetch("modules/mod_list/menu.tpl",null,$language));


$sql = $db->prepare("SELECT * FROM ".DB_PREFIX."modules ORDER BY Name ASC");
$res = $db->execute($sql);
if ($res && $res->RecordCount() > 0){
  $smarty->assign("modules_arr",$res->GetArray());
} else $smarty->assign("modules_arr",array());

$smarty->assign("MODULES",$smarty->fetch('modules/mod_list/mod_list.tpl', null, $language));

$xajax->registerFunction("show_form_modules");
$xajax->registerFunction("modules_add");
$xajax->registerFunction("modules_refresh");
$xajax->registerFunction("modules_change");
$xajax->registerFunction("modules_delete");

function show_form_modules($form,$id=""){
  global $smarty,$language,$db,$lang;

  $objResponse = new xajaxResponse();

  if (check_rights($form)){
    if (isset($id) && !empty($id)){
      $sql = $db->prepare("SELECT * FROM ".DB_PREFIX."modules WHERE ID='".$id."'");
      $res = $db->Execute($sql);
      if ($res && $res->RecordCount() > 0){
        $smarty->assign("modules_item",$res->GetArray());
      } else $smarty->assign("modules_item",array());
    }
    $smarty->assign("tab_name",$lang[$form."_modules"]);
    
    $file = $smarty->fetch('modules/mod_list/'.$form.'.tpl', null, $language);
    $objResponse->addScriptCall("deleteTab",false,1,'dhtmlgoodies_tabView1');
    $objResponse->addScriptCall("createNewTab","dhtmlgoodies_tabView1",$lang[$form."_modules"],$file,'');

  }  else $objResponse->addAlert($lang["per_cant_".$form]);

  return $objResponse->getXML();
}

function modules_refresh(){
global $db,$smarty,$language,$user;

  $objResponse = new xajaxResponse();
  $sql = $db->prepare("SELECT * FROM ".DB_PREFIX."modules ORDER BY Name ASC");
  $res = $db->execute($sql);
  if ($res && $res->RecordCount() > 0){
    $smarty->assign("modules_arr",$res->GetArray());
  } else $smarty->assign("modules_arr",array());
  
  $table = $smarty->fetch('modules/mod_list/mod_list.tpl', null, $language);  
  $objResponse->addAssign('visual_modules', "innerHTML", $table);
  $objResponse->addScriptCall("initTableWidget",'myTable',"100%",'480',"Array(false,'S')");
  
  return $objResponse->getXML();
    
}

function modules_add($data){
  global $smarty,$language,$db,$lang,$user;

  $objResponse = new xajaxResponse();
  if (!empty($data["Name"])){
    
    $sql = $db->prepare("INSERT INTO ".DB_PREFIX."modules(UserID,Name) VALUES('".$user->id."','".$data["Name"]."')");
    if($db->Execute($sql)){
        $objResponse->addScriptCall("xajax_modules_refresh()");
        $objResponse->addAlert($lang["modules_add_suc"]);
        $objResponse->addScriptCall("deleteTab",false,1,'dhtmlgoodies_tabView1');
    }
  } else $objResponse->addAlert($lang["requered_data_absent"]);
  
  return $objResponse->getXML();
}

function modules_change($data){
  global $db,$lang,$user;

  $objResponse = new xajaxResponse();
  if ($data["Name"]!=""){
    $sql = $db->prepare("UPDATE ".DB_PREFIX."modules SET Name='".$data["Name"]."' WHERE ID='".$data["id"]."'");  
    $res = $db->Execute($sql);

    if ($res){
      $objResponse->addScriptCall("xajax_modules_refresh");
      $objResponse->addAlert($lang["modules_change_suc"]);
      $objResponse->addScriptCall("deleteTab",false,1,'dhtmlgoodies_tabView1');
    }
  } else $objResponse->addAlert($lang["requered_data_absent"]);
  return $objResponse->getXML();
}

function modules_delete($id){
  global $db,$lang;

  $objResponse = new xajaxResponse();
  
  if (check_rights('delete')){
    if ($id!=""){
      $sql = $db->prepare("SELECT Delete FROM ".DB_PREFIX."modules WHERE ID='".$id."'");
      $res = $db->Execute($sql);
      if ($res && $res->RecordCount() > 0){
      		if ($res->fields["Delete"]=="1"){
      			$dsql = $db->prepare("DELETE FROM ".DB_PREFIX."modules WHERE ID='".$id."'");
      			if ($db->Execute($dsql)){
        			$objResponse->addScriptCall("xajax_modules_refresh");
      			}
      		} else {
      			$objResponse->addAlert($lang["modules_cant_delete"]);	
      		}
      }
    } else $objResponse->addAlert($lang["check_items_for_deleting"]);
  } else $objResponse->addAlert($lang["per_cant_delete"]);

  return $objResponse->getXML();
}

?>
