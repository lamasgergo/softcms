<?php
$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__));

ini_set('display_errors',1);
error_reporting(2039);

include_once(dirname(__FILE__).'/kernel/Settings.php');
Settings::loadFS();
include_once(dirname(__FILE__)."/kernel/adodb.php");
session_start();
Settings::load();
define('DB_PREFIX', Settings::get('database_prefix'));

$request = $_SERVER['REQUEST_URI'];

$url = mysql_real_escape_string(trim($request,'/'));
$query = $db->Prepare("SELECT Type, ID FROM ".DB_PREFIX."data WHERE Url='{$url}'");
$rs = $db->Execute($query);
if ($rs && $rs->RecordCount() > 0){
    var_dump($rs->fields);
}
?>
