<?

$sql = $db->prepare("SELECT * FROM ".DB_PREFIX."meta");
$res = $db->Execute($sql);
if ($res && $res->RecordCount() > 0){
	$smarty->assign("items",$res->GetArray());
} else $smarty->assign("items",array());

$parse_main = $smarty->fetch('meta/meta.tpl', null, $language);

$xajax->registerFunction("save_meta");


function save_meta($data){
global $db,$smarty,$language,$lang;

  $objResponse = new xajaxResponse();
  
  foreach ($data as $key=>$val){
  	$db->Execute("UPDATE ".DB_PREFIX."meta SET MetaValue='".$val."' WHERE MetaName='".$key."'");
  }

  $objResponse->addAlert($lang["meta_saved_suc"]);
  
  return $objResponse->getXML();
    
}

?>