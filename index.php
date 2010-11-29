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
include_once(dirname(__FILE__)."/kernel/User.php");
include_once(dirname(__FILE__)."/kernel/Modules.php");
include_once(dirname(__FILE__)."/kernel/Meta.php");

$language = Settings::get('default_lang');

$request = $_SERVER['REQUEST_URI'];

$url = mysql_real_escape_string(trim($request,'/'));
$urlArr = explode("/", $url);
if (count($urlArr) )
$query = $db->Prepare("SELECT Type, ID FROM ".DB_PREFIX."data_categories WHERE Url='{$url}'");
$query = $db->Prepare("SELECT Type, ID FROM ".DB_PREFIX."data WHERE Url='{$url}'");
$rs = $db->Execute($query);
if ($rs && $rs->RecordCount() > 0){
    $module = $rs->fields['Type'];
    if (Modules::check($module)){
        $smarty->assign('id', $rs->fields['ID']);
        Meta::setMetaByID($rs->fields['ID']);
        if ($smarty->templateExists("{$module}/{$url}.tpl")){
            $smarty->display("{$module}/{$url}.tpl", null, $language);
        } else {
            $smarty->display("{$module}/index.tpl", null, $language);
        }
    }
} else {
    $smarty->display("index.tpl", null, $language);
}
?>
