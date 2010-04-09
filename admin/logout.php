<?php
$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__).'/../');
include_once($_SERVER['DOCUMENT_ROOT']."/kernel/init.php");
ObjectRegistry::getInstance()->get('user')->logout();
echo "<script language='javascript'>location.replace('/admin/');</script>";
?>