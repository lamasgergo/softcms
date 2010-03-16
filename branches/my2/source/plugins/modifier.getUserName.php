<?
function smarty_modifier_getUserName($id)
{
  global $lang,$db;
  $ret = $id;
  $sql = $db->prepare("SELECT Name,Familyname FROM ".DB_PREFIX."users WHERE ID='".$id."'");
  $res = $db->Execute($sql);
  if ($res && $res->RecordCount() > 0){
    $ret = $res->fields["Name"]." ".$res->fields["Familyname"];
  }
  return $ret;
}
?>