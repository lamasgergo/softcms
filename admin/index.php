<?php
ini_set('display_errors', 1);
$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__).'/../');

include_once(dirname(__FILE__)."/common/init.php");

$user = ObjectRegistry::getInstance()->get('user');

/* auth */
if (isset($_POST["logout"])){
	$user->logout();
}
if (isset($_POST["login"]) && !empty($_POST["login"]) && isset($_POST["password"]) && !empty($_POST["password"])){
  $user->login($_POST["login"],$_POST["password"], true);
}

/* check auth*/
if ($user->isAuth()){
    include_once(dirname(__FILE__)."/common/admin.php");
} else {
  include_once(dirname(__FILE__)."/common/login.php");
}



?>
