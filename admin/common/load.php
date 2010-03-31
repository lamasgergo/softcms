<?php
session_start();
include_once(dirname(__FILE__)."/../../kernel/ObjectRegistry.php");
$obReg = ObjectRegistry::getInstance();
include_once(dirname(__FILE__)."/../../kernel/lang.php");
include_once(dirname(__FILE__)."/../../kernel/smarty.php");
$obReg->set('smarty', $smarty);
include_once(dirname(__FILE__)."/../../kernel/adodb.php");
$obReg->set('db', $db);
include_once(dirname(__FILE__)."/../../kernel/user.class.php");
$user = User::getInstance();
$obReg->set('user', $user);

include_once(dirname(__FILE__)."/../common/Access.php");
include_once(dirname(__FILE__)."/../common/functions.php");
include_once(dirname(__FILE__)."/../../kernel/locale.php");

$user->isBackend(true);
if (!$user->isAuth()){
    header("/admin/?return=".$_SERVER['REQUEST_URI']);
    exit();
};


$smarty->template_dir  = $_SERVER['DOCUMENT_ROOT'].'/admin/templates';

$language = $user->get('EditLang');
$obReg->set('language', $language);
loadLangArr($lang,$language);

$locale = new Locale();
$obReg->set('locale', $locale);



$smarty->assign("images",IMAGES_DIR);
$smarty->assign("css",CSS_DIR);
$smarty->assign("js",JS_DIR);

?>