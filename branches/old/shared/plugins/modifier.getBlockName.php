<?
function smarty_modifier_getBlockName($id)
{
  global $lang,$db;
  $ret = $id;
  $sql = $db->prepare("SELECT Name FROM ".DB_PREFIX."blocks WHERE ID='".$id."'");
  $res = $db->Execute($sql);
  if ($res && $res->RecordCount() > 0){
    $ret = $res->fields["Name"];
  }
  if ($id=="0") $ret="";
  return $ret;
}
?>