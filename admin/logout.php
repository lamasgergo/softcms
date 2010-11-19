<?php
$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__).'/../');
include_once(dirname(__FILE__).'/../'."/kernel/init.php");
$user = User::getInstance();
$user->logout();
echo "<script language='javascript'>location.replace('/admin/');</script>";
?>