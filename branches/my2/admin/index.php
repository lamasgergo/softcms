<?php
ini_set('display_errors', 1);
$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__).'/../');

include_once($_SERVER['DOCUMENT_ROOT']."/config/config.php");
include_once($_SERVER['DOCUMENT_ROOT']."/admin/common/load.php");

/* auth */
if (isset($_POST["logout"])){
	$user->logout();
}
if (isset($_POST["login"]) && !empty($_POST["login"]) && isset($_POST["password"]) && !empty($_POST["password"])){
  $user->login($_POST["login"],$_POST["password"], true);
}

/* check auth*/
if ($user->isAuth()){
    include_once(__PATH__."/admin/common/admin.php");
} else {
  include_once(__PATH__."/admin/common/login.php");
}



?>
