<?
function smarty_modifier_ShowDesign($id)
{
  global $lang,$db;
  $ret = $id;
  $sql = $db->prepare("SELECT Name FROM ".DB_PREFIX."design WHERE ID='".$id."'");
  $res = $db->Execute($sql);
  if ($res && $res->RecordCount() > 0){
    if (isset($lang[$res->fields["Name"]])){
      $ret = $lang[$res->fields["Name"]];
    } else {
      $ret = $res->fields["Name"];
    }
  }
  return $ret;
}
?>