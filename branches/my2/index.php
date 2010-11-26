<?php
$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__));

ini_set('display_errors',1);
error_reporting(2039);

include_once(dirname(__FILE__).'/kernel/Settings.php');
Settings::loadFS();
include_once(dirname(__FILE__)."/kernel/adodb.php");
Settings::load();
include_once(dirname(__FILE__)."/kernel/smarty.php");
session_start();
define('DB_PREFIX', Settings::get('database_prefix'));
include_once(dirname(__FILE__)."/kernel/Modules.php");
include_once(dirname(__FILE__)."/kernel/Base.php");

$request = $_SERVER['REQUEST_URI'];

$url = mysql_real_escape_string(trim($request,'/'));
$query = $db->Prepare("SELECT Type, ID FROM ".DB_PREFIX."data WHERE Url='{$url}'");
$rs = $db->Execute($query);
if ($rs && $rs->RecordCount() > 0){
    $module = $rs->fields['Type'];
    if (Modules::check($module)){
        $modulePath = dirname(__FILE__)."/modules/{$module}/{$module}.php";
        include_once($modulePath);
        $dataObj = new $module();
        $dataObj->show();
    }
} else {
    $smarty->display("index.tpl");
}
?>
