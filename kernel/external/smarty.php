<?
require_once(dirname(__FILE__)."/smarty/Smarty.class.php");
$smarty = new Smarty;
$smarty->compile_check = true;
$smarty->force_compile = true;
$smarty->compile_dir   = $_SERVER['DOCUMENT_ROOT'].'/shared/templates_c/';
$smarty->plugins_dir[] = $_SERVER['DOCUMENT_ROOT'].'/shared/plugins/';
$smarty->template_dir  = $_SERVER['DOCUMENT_ROOT'].'/design/';
$smarty->caching       = false;
$smarty->debugging     = false;

$smarty->autoload_filters = array('post' => array('error','lang'));

?>
