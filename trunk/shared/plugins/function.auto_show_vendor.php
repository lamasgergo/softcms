<?
function smarty_function_auto_show_vendor($params, &$smarty)
{
    $db = &$smarty->get_registered_object("db");
        $id = $params['id'];
        $ret = "";
        if (isset($id) && !empty($id)){
          $sql = $db->prepare("SELECT Name FROM ".ADB_PREFIX."vendors WHERE ID='".$id."'");
          $res = $db->Execute($sql);
          if ($res && $res->RecordCount() > 0){
              $ret = $res->fields["Name"];
          }
        }
        
     unset($db);
        return $ret;
}



?>