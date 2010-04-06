<?php
require_once(dirname(__FILE__)."/smarty/Smarty.class.php");
include_once(dirname(__FILE__).'/Settings.php');

$smarty = new Smarty;
$smarty->compile_check = true;
$smarty->force_compile = true;
$smarty->template_dir  = $_SERVER['DOCUMENT_ROOT'].Settings::get('smarty_templates_dir');
$smarty->compile_dir   = $_SERVER['DOCUMENT_ROOT'].Settings::get('smarty_compiled_dir');
$smarty->plugins_dir[] = $_SERVER['DOCUMENT_ROOT'].Settings::get('smarty_plugins_dir');
$smarty->caching       = Settings::get('smarty_caching');
$smarty->trusted_dir   = $_SERVER['DOCUMENT_ROOT'].Settings::get('smarty_compiled_dir');

$smarty->autoload_filters = array('post' => array('lang'));
?>
