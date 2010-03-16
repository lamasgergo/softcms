<?

$smarty->assign("groups",array());

$smarty->assign("GROUPS",$smarty->fetch('permissions/groups/groups.tpl', null, $language));


$xajax->registerFunction("show_groups");


function show_groups($check){
global $db,$smarty,$language;

  $objResponse = new xajaxResponse();
  
  if ($check=="true"){
    $sql = $db->prepare("SELECT * FROM ".DB_PREFIX."groups ORDER BY Name ASC");
    $res = $db->execute($sql);
    if ($res && $res->RecordCount() > 0){
      $smarty->assign("groups",$res->GetArray());
    }
  } else {
    $smarty->assign("groups",array());
  }
  
  $table = $smarty->fetch('permissions/groups/groups.tpl', null, $language);  
  $objResponse->addAssign('permission_groups', "innerHTML", $table);
  $objResponse->addScript("initTableWidget('myTable','270','300',Array(false,'S'));");
  $objResponse->addAssign('perm_area', "innerHTML", "");

  
  return $objResponse->getXML();
    
}


?>