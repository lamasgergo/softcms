<?php
ini_set('display_errors', 1);
$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__).'/../');

$debugInfo = array();

require_once(dirname(__FILE__). '/../' . '/kernel/init.php');
require_once(dirname(__FILE__).'/classes/admin.php');

$admin = new Admin();
$admin->display();



?>
