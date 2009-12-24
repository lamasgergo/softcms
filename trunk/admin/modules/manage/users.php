<?

/* define menu*/
$smarty->assign("mod","users");
$smarty->assign("users_menu",$smarty->fetch("manage/users/menu.tpl",null,$language));


$sql = $db->prepare("SELECT *, ".DB_PREFIX."users.ID as ID , ".DB_PREFIX."users.Name as UName, ".DB_PREFIX."groups.Name as GroupName FROM ".DB_PREFIX."users LEFT JOIN ".DB_PREFIX."groups ON (".DB_PREFIX."groups.ID=".DB_PREFIX."users.GroupID) ORDER BY ".DB_PREFIX."users.ID ASC");
$res = $db->execute($sql);
if ($res && $res->RecordCount() > 0){
  $smarty->assign("users",$res->GetArray());
}



$smarty->assign("USERS",$smarty->fetch('manage/users/users.tpl', null, $language));

$xajax->registerFunction("show_form_users");
$xajax->registerFunction("add_users");
$xajax->registerFunction("change_users");
$xajax->registerFunction("delete_users");
$xajax->registerFunction("refresh_users");
$xajax->registerFunction("publish_users");


function refresh_users($id=""){
  global $db,$smarty,$language;
  $where = "";
  if (!empty($id)) $where = "WHERE ".DB_PREFIX."users.GroupID='".$id."'";
  $sql = $db->prepare("SELECT *, ".DB_PREFIX."users.ID as ID , ".DB_PREFIX."users.Name as UName, ".DB_PREFIX."groups.Name as GroupName FROM ".DB_PREFIX."users LEFT JOIN ".DB_PREFIX."groups ON (".DB_PREFIX."groups.ID=".DB_PREFIX."users.GroupID) ".$where." ORDER BY ".DB_PREFIX."users.ID ASC");
  $res = $db->execute($sql);
  if ($res && $res->RecordCount() > 0){
    $smarty->assign("users",$res->GetArray());
  } else $smarty->assign("users",array());
  $table = $smarty->fetch('manage/users/table.tpl', null, $language);
  $objResponse = new xajaxResponse();
  $objResponse->addAssign('visual_users', "innerHTML", $table);
  $objResponse->addScriptCall("initTableWidget",'myTable',"100%",'480',"Array(false,'S',false,'N','S','S','S','N','S','S')");
  return $objResponse;
}

function show_form_users($form,$id=""){
  global $smarty,$language,$db,$lang;

  $objResponse = new xajaxResponse();
    if (check_rights($form)){
    /*lang*/
    $sql = $db->prepare("SELECT * FROM ".DB_PREFIX."lang ORDER BY ID ASC");
    $res = $db->Execute($sql);
    if ($res && $res->RecordCount() > 0){
      $lang_ids = array();
      $lang_names = array();
      while (!$res->EOF){
        array_push($lang_ids,$res->fields["ID"]);
        if ($lang[$res->fields["Name"]]){
          array_push($lang_names, $lang[$res->fields["Name"]]); 
        } else array_push($lang_names,$res->fields["Description"]);
        $res->MoveNext(); 
      }
      $smarty->assign('lang_ids', $lang_ids);
      $smarty->assign('lang_names', $lang_names);
    } else {
      $smarty->assign('lang_ids', array());
      $smarty->assign('lang_names', array());
    }
    /*lang*/
    /*groups*/
    $sql = $db->prepare("SELECT * FROM ".DB_PREFIX."groups ORDER BY ID ASC");
    $res = $db->Execute($sql);
    if ($res && $res->RecordCount() > 0){
      $groups_ids = array();
      $groups_names = array();
      while (!$res->EOF){
        array_push($groups_ids,$res->fields["ID"]);
        array_push($groups_names,$res->fields["Name"]);
        $res->MoveNext(); 
      }
      $smarty->assign('groups_ids', $groups_ids);
      $smarty->assign('groups_names', $groups_names);
    } else {
      $smarty->assign('groups_ids', array());
      $smarty->assign('groups_names', array());
    }
    /*groups*/
  
    if (isset($id) && !empty($id)){
      $sql = $db->prepare("SELECT * FROM ".DB_PREFIX."users WHERE ID='".$id."'");
      $res = $db->Execute($sql);
      if ($res && $res->RecordCount() > 0){
        if ($res->fields["Login"]=="admin"){
          $smarty->assign("login_dis","style='display:none;'");
          $smarty->assign("group_dis","style='display:none;'");
          $smarty->assign("published_dis","style='display:none;'");
        }
        $smarty->assign("users",$res->GetArray());
      }
    }
    $file = $smarty->fetch('manage/users/'.$form.'.tpl',null,$language);
    $objResponse->addScriptCall("deleteTab",false,2,'dhtmlgoodies_tabView1');
    $objResponse->addScriptCall("createNewTab","dhtmlgoodies_tabView1",$lang["users_".$form],$file,'');

  } else $objResponse->addAlert($lang["per_cant_".$form]);

  return $objResponse->getXML();
}

function add_users($data){
  global $db,$lang,$user;

  $objResponse = new xajaxResponse();

  if ($data["login"]!="" && $data["password"]!="" && $data["langid"]!="" && $data["groupsid"]!="" && $data["name"]!=""){
    $sql = $db->prepare("SELECT ID FROM ".DB_PREFIX."users WHERE Login='".$data["login"]."'");
    $res = $db->Execute($sql);
    if ($res && $res->RecordCount() > 0){
      $objResponse->addAlert($lang["users_login_exist"]);
    } else {
      $password = $user->_newPassword($data["password"]);
      $published =$data["published"];
        if ($published=="") $published = "0";
      $sql = $db->prepare("INSERT INTO ".DB_PREFIX."users(Login,Password,LangID,GroupID,Name,Familyname,Email,Country,ZIP,City,Address,Published,Phone,Cellphone) VALUES('".$data["login"]."','".$password."','".$data["langid"]."','".$data["groupsid"]."','".$data["name"]."','".$data["familyname"]."','".$data["email"]."','".$data["country"]."','".$data["zip"]."','".$data["city"]."','".$data["address"]."','".$published."','".$data["phone"]."','".$data["cellphone"]."')");
      $res = $db->Execute($sql);
  
      if ($res){
        $objResponse->addScript("xajax_refresh_users();");
        $objResponse->addAlert($lang["users_add_suc"]);
        $objResponse->addScriptCall("deleteTab",false,2,'dhtmlgoodies_tabView1');
        $objResponse->addScriptCall("showTab",'dhtmlgoodies_tabView1',1);
      } else {
  
        $objResponse->addAssign('dynamic', "innerHTML",$sql);
      }
    }
  } else $objResponse->addAlert($lang["requered_data_absent"]);
  return $objResponse->getXML();
}

function publish_users($id,$value){
  global $db,$lang;
  $objResponse = new xajaxResponse();
  if (check_rights('publish')){
    if ($value=="true"){
      $value = "1";
    } else  $value = "0";
    if ($id!=""){
      $cksql = $db->prepare("SELECT Login FROM ".DB_PREFIX."users WHERE ID='".$id."'");
      $ckres = $db->Execute($cksql);
      if ($ckres && $ckres->RecordCount() > 0){
        if ($ckres->fields["Login"]!="admin"){
          $sql = $db->prepare("UPDATE ".DB_PREFIX."users SET Published='".$value."' WHERE ID='".$id."'");
          $res = $db->Execute($sql);
        } else {
          $objResponse = refresh_users();
          $objResponse->addAlert($lang["users_admin_cant_unpublish"]);  
          $objResponse->addAssign('dynamic', "innerHTML", "");
        }
      }
    }
  } else $objResponse->addAlert($lang["per_cant_publish"]);
  return $objResponse->getXML();
}


function change_users($data){
  global $db,$lang,$user;

  $objResponse = new xajaxResponse();
  if ($data["login"]!=""  && $data["langid"]!="" && $data["groupsid"]!="" && $data["name"]!=""){
    (isset($data["published"]) && $data["published"]="1")? $published="1" : $published = "0";
    if ($data["password"]!=""){
      $password = $user->_newPassword($data["password"]);
      $sql = $db->prepare("UPDATE ".DB_PREFIX."users SET Login='".$data["login"]."', Password='".$password."', LangID='".$data["langid"]."', GroupID='".$data["groupsid"]."', Name='".$data["name"]."', Familyname='".$data["familyname"]."', Email='".$data["email"]."', Country='".$data["country"]."', ZIP='".$data["zip"]."', City='".$data["city"]."', Address='".$data["address"]."', Published='".$published."', Phone='".$data["phone"]."', Cellphone='".$data["cellphone"]."' WHERE ID='".$data["id"]."'");
    } else{
      $sql = $db->prepare("UPDATE ".DB_PREFIX."users SET Login='".$data["login"]."', LangID='".$data["langid"]."', GroupID='".$data["groupsid"]."', Name='".$data["name"]."', Familyname='".$data["familyname"]."', Email='".$data["email"]."', Country='".$data["country"]."', ZIP='".$data["zip"]."', City='".$data["city"]."', Address='".$data["address"]."', Published='".$published."', Phone='".$data["phone"]."', Cellphone='".$data["cellphone"]."' WHERE ID='".$data["id"]."'");  
    }
    $res = $db->Execute($sql);

    if ($res){
        $objResponse->addScript("xajax_refresh_users();");
      $objResponse->addAlert($lang["users_change_suc"]);
        $objResponse->addScriptCall("deleteTab",false,2,'dhtmlgoodies_tabView1');
        $objResponse->addScriptCall("showTab",'dhtmlgoodies_tabView1',1);

    } else {
      $objResponse->addAssign('dynamic', "innerHTML",$sql);
    }
  } else $objResponse->addAlert($lang["requered_data_absent"]);
  return $objResponse->getXML();
}

function delete_users($data){
  global $db,$lang;
  $admin_delete = false;
  $delete = false;
  
  $objResponse = new xajaxResponse();

  if (check_rights('delete')){
    if (is_array($data)){
      foreach ($data as $id){
        $cksql = $db->prepare("SELECT Login FROM ".DB_PREFIX."users WHERE ID='".$id."'");
        $ckres = $db->Execute($cksql);
        if ($ckres && $ckres->RecordCount() > 0){
          if ($ckres->fields["Login"]!="admin"){
            $sql = $db->prepare("DELETE FROM ".DB_PREFIX."users WHERE ID='".$id."'");
            $res = $db->Execute($sql);
            $delete = true;
          } else {
            $admin_delete = true;
          }
        }
      }
      
      $objResponse = refresh_users();
      $objResponse->addAssign('dynamic', "innerHTML","");
      if ($admin_delete) $objResponse->addAlert($lang["users_admin_cant_delete"]);
      if ($delete) $objResponse->addAlert($lang["users_delete_suc"]);
      
    } else $objResponse->addAlert($lang["check_items_for_deleting"]);
  } else $objResponse->addAlert($lang["per_cant_delete"]);
  return $objResponse->getXML();
}
?>