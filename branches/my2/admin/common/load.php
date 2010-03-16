<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT']."/kernel/adodb.php");
include_once($_SERVER['DOCUMENT_ROOT']."/kernel/lang.php");
include_once($_SERVER['DOCUMENT_ROOT']."/kernel/smarty.php");
include_once($_SERVER['DOCUMENT_ROOT']."/kernel/user.class.php");
include_once($_SERVER['DOCUMENT_ROOT']."/kernel/user.class.php");
include_once($_SERVER['DOCUMENT_ROOT']."/admin/common/Access.php");
include_once($_SERVER['DOCUMENT_ROOT']."/admin/common/functions.php");

$smarty->template_dir  = $_SERVER['DOCUMENT_ROOT'].'/admin/templates';

$user = new User;
$user->isBackend(true);

$language = $user->get_lang();
loadLangArr($lang,$language);


$smarty->assign("images",IMAGES_DIR);
$smarty->assign("css",CSS_DIR);
$smarty->assign("js",JS_DIR);

?>