<?php
ini_set('display_errors', 1);
$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__).'/../');

require_once($_SERVER['DOCUMENT_ROOT']."/kernel/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/admin/common/admin.php");

$admin = new Admin();
$admin->display();



?>
