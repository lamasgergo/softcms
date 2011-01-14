<?
function smarty_function_admin_menu($params, &$smarty){
    global $lang, $db, $smarty, $user, $config;

    $type = $params['type'];

	$modules = array();
    $sql = $db->prepare("SELECT ModGroup FROM ".DB_PREFIX."modules WHERE Active='1' GROUP BY ModGroup ORDER BY ID ASC");
	$res = $db->Execute($sql);
	if ($res && $res->RecordCount() > 0){
		while (!$res->EOF){
			$sql2 = $db->prepare("SELECT * FROM ".DB_PREFIX."modules WHERE ModGroup='".$res->fields["ModGroup"]."' AND Active='1' ORDER BY Name ASC");
			$res2 = $db->execute($sql2);
			if ($res2 && $res2->RecordCount() > 0){
				while (!$res2->EOF){
					$modules[$res->fields["ModGroup"]][] = $res2->fields;
					$res2->MoveNext();
				}
			} 
			$res->MoveNext();
		}
	}
	
	$smarty->assign("modules", $modules);
    $smarty->assign("langs",$config->SUPPORTED_LANGUAGES_LIST);
    $smarty->assign("GUILang",$user->data['GUILang']);
    $smarty->assign("ContentLang",$user->data['ContentLang']);
    $smarty->assign("top_menu",$menu_top);
    $smarty->assign("username",$user->data['Login']);

	return $smarty->fetch("templates/common/".$type."_menu.tpl",null,$this->language);
}

?>
