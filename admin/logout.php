<?php
$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__).'/../');
include_once(dirname(__FILE__)."/common/init.php");
ObjectRegistry::getInstance()->get('user')->logout();
echo "<script language='javascript'>location.replace('/admin/');</script>";
?>