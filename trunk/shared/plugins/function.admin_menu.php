<?
function smarty_function_admin_menu($params, &$smarty)
{
    global
    $lang, $db, $smarty, $user;

    $type = $params['type'];

    $sql = $db->prepare("SELECT * FROM ".DB_PREFIX."modules WHERE Active='1' ORDER BY ModGroup ASC, Name ASC");
    $res = $db->execute($sql);
    if ($res && $res->RecordCount() > 0){
        $menu_top = $res->getArray();
    }
    $smarty->assign("top_menu",$menu_top);
    $smarty->assign("username",$user->data['Login']);
    return $smarty->fetch("templates/common/".$type."_menu.tpl",null,$this->language);

    unset($db);
    return $ret;
}

?>
