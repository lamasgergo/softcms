<?php
require_once(dirname(__FILE__)."/smarty/Smarty.class.php");
include_once(dirname(__FILE__).'/Settings.php');

$smarty = new Smarty();
$smarty->compile_check = true;
$smarty->force_compile = true;
$smarty->debugging = false;
$smarty->caching       = Settings::get('smarty_caching');
$smarty->compile_dir   = $_SERVER['DOCUMENT_ROOT'].Settings::get('smarty_compiled_dir');
$smarty->trusted_dir   = $_SERVER['DOCUMENT_ROOT'].Settings::get('smarty_compiled_dir');
$smarty->autoload_filters = array('post' => array('lang'));

$smarty->addTemplateDir($_SERVER['DOCUMENT_ROOT'].Settings::get('smarty_templates_dir'));
if (Settings::get('theme')){
    $smarty->addTemplateDir($smarty->template_dir.'/'.Settings::get('theme'));
}
$smarty->addPluginsDir($_SERVER['DOCUMENT_ROOT'].Settings::get('smarty_plugins_dir'));
$smarty->addPluginsDir($_SERVER['DOCUMENT_ROOT'].'/kernel/smarty/plugins');
$smarty->addPluginsDir($_SERVER['DOCUMENT_ROOT'].'/kernel/smarty/sysplugins');
$smarty->addPluginsDir($_SERVER['DOCUMENT_ROOT'].'/admin/plugins');

?>
