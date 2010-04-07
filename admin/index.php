<?php
ini_set('display_errors', 1);
$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__).'/../');

include_once(dirname(__FILE__)."/common/init.php");
include_once(dirname(__FILE__)."/common/admin.php");

$admin = new Admin();
$admin->display();



?>
