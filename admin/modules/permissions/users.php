<?
#$sql = $db->prepare("SELECT *, ".DB_PREFIX."users.ID as ID , ".DB_PREFIX."users.Name as , ".DB_PREFIX."groups.Name as GroupName FROM ".DB_PREFIX."users LEFT JOIN ".DB_PREFIX."groups ON (".DB_PREFIX."groups.ID=".DB_PREFIX."users.GroupID) ORDER BY ".DB_PREFIX."users.ID ASC");
#$res = $db->execute($sql);

#if ($res && $res->RecordCount() > 0){
#  $smarty->assign("users",$res->GetArray());
#}

$smarty->assign("users",array());

$smarty->assign("USERS",$smarty->fetch('permissions/users/users.tpl', null, $language));


?>