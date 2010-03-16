<?
function smarty_function_mod_print_header($params, &$smarty)
{
  $db = &$smarty->get_registered_object("db");
  
  $var = $params["var"];  
  if (empty($var)){
    $var = "print_text";
  }
  $val = "";

  
  $sql = $db->prepare("SELECT Value FROM ".DB_PREFIX."settings WHERE Name='".$var."'");
  $res = $db->Execute($sql);

  if ($res && $res->RecordCount() > 0){
    $val = preg_replace("/\n/","<br />",$res->fields["Value"])."<br />";
  }

 
  unset($db);


  return $val;
}

?>