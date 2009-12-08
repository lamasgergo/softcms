<?
function smarty_modifier_MenuNameById($id)
{
  global $lang,$db;
  $ret = $id;
  $sql = $db->prepare("SELECT Name FROM ".DB_PREFIX."menu_group WHERE ID='".$id."'");
  $res = $db->Execute($sql);
  if ($res && $res->RecordCount() > 0){
    $ret = $res->fields["Name"];
  }
  return $ret;
}
?>