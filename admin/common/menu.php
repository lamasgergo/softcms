<?php
  
$smarty->assign("edit_lang_block",parse_edit_lang());

$smarty->assign("top_menu",get_top_menu());
  
$parse_menu = $smarty->fetch("index_menu/menu.tpl",null,$language);
  
$xajax->registerFunction("change_edit_lang");  

function parse_edit_lang(){
global $db,$smarty,$user,$config;
  $ret = "";
	foreach ($config->SUPPORTED_LANGUAGES_LIST as $lang=>$name){
      if ($lang == $user->data['lang']){
		$ret .= '<div style="float: left; background: url(/source/images/icons/selected_lang.gif) 0% 30% no-repeat; height: 35px; width: 35px; text-align: center;" onMouseOver="this.style.background=\'url(/source/images/icons/selected_lang_over.gif) 0% 30% no-repeat\';" onMouseOut="this.style.background=\'url(/source/images/icons/selected_lang.gif) 0% 30% no-repeat\';">';
		$ret .= "<input type='image' style='margin: 12px 0px 0px 3px;' src='/source/images/flags/".$lang.".gif' border='0' onclick='xajax_change_edit_lang(\"".$lang."\");'>&nbsp;";
        $ret .= '</div>';
      } else {
		$ret .= '<div style="float: left; height: 35px; width: 35px; text-align: center; padding: 2px 0px 0px 2px;" onMouseOver="this.style.background=\'url(/source/images/icons/selected_lang_over.gif) 0% 30% no-repeat\';" onMouseOut="this.style.background=\'\';">';
		$ret .= "<input type='image' style='margin: 10px 0px 0px 3px;' src='/source/images/flags/".$lang.".gif' border='0' onclick='xajax_change_edit_lang(\"".$lang."\");'>&nbsp;";
		$ret .= '</div>';
	  }
     }
  return $ret;
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