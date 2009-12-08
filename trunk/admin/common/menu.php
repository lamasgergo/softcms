<?

parse_edit_lang();
  
$smarty->assign("username",$user->name."&nbsp;".$user->familyname);

$smarty->assign("top_menu",get_top_menu());
  
$parse_menu = $smarty->fetch("templates/common/top_menu.tpl",null,$language);
  
$xajax->registerFunction("change_edit_lang");  

function parse_edit_lang(){
global $db,$smarty,$user, $langService, $language;
  
  $smarty->assign("lang_list", $langService->getLanguagesList());
  $smarty->assign("cur_lang", $user->edit_lang_id);
  $smarty->assign("LANG", $smarty->fetch("templates/common/languages.tpl",null,$language));
}  

function change_edit_lang($edit_lang_id){
global $xajax,$user;
  $user->change_edit_lang($edit_lang_id);
  $objResponse = new xajaxResponse();
  $objResponse->addScript("location.reload();");
  return $objResponse->getXML();
}

function get_top_menu(){
global $db;
	$arr = array();
	$sql = $db->prepare("SELECT * FROM ".DB_PREFIX."modules WHERE Active='1' ORDER BY ModGroup ASC, Name ASC");
	$res = $db->execute($sql);
	if ($res && $res->RecordCount() > 0){
		$arr = $res->getArray();
	}
	return $arr;
}
?>