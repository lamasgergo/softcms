<?
function smarty_modifier_getMotoAucCatalogNameById($id)
{
  global $lang,$db;
  $ret = $id;
  $sql = $db->prepare("SELECT Name FROM ".MOTO_AUC_PREFIX."category WHERE ID='".$id."'");
  $res = $db->Execute($sql);
  if ($res && $res->RecordCount() > 0){
    $ret = $res->fields["Name"];
  }
  if ($id=="0") $ret="";
  return $ret;
}
?>