<?php
$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__).'/../');
session_start();

define("BACKEND", true);
include_once("../config/config.php");
include_once($_SERVER['DOCUMENT_ROOT']."/kernel/init.php");


$smarty->template_dir  = dirname(__FILE__).'/';

$smarty->assign("images", '/admin/images');
$smarty->assign("css", '/admin/css');
$smarty->assign("js", '/shared/js');


/* auth */
if (isset($_POST["logout"])){
    $user->logout();
}
if (isset($_POST["login"]) && !empty($_POST["login"]) && isset($_POST["password"]) && !empty($_POST["password"])){
    $user->auth($_POST["login"],$_POST["password"],true);
}

$page = new AdminPage();

$page->display();


/* check auth*/
/*
if ($user->is_auth()){
    include_once($_SERVER['DOCUMENT_ROOT']."/admin/common/admin.php");
} else {
    include_once($_SERVER['DOCUMENT_ROOT']."/admin/common/login.php");
}
*/
?>
