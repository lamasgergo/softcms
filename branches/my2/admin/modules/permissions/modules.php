<?
$sql = $db->prepare("SELECT * FROM ".DB_PREFIX."modules ORDER BY Link ASC");
$res = $db->execute($sql);

if ($res && $res->RecordCount() > 0){
  $smarty->assign("modules",$res->GetArray());
}

$smarty->assign("MODULES",$smarty->fetch('permissions/modules/modules.tpl', null, $language));

?>