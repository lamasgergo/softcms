<?
function smarty_modifier_getUserLogin($id)
{
  global $lang,$db;
  $ret = $id;
  $sql = $db->prepare("SELECT Login FROM ".DB_PREFIX."users WHERE ID='".$id."'");
  $res = $db->Execute($sql);
  if ($res && $res->RecordCount() > 0){
    $ret = $res->fields["Login"];
  } else {
	  $ret = $lang["Guest"] ? $lang["Guest"] : 'Guest';
  }
  return $ret;
}
?>