<?
require_once(dirname(__FILE__)."/smarty/Smarty.class.php");
$smarty = new Smarty;
$smarty->compile_check = true;
$smarty->force_compile = true;
$smarty->template_dir  = TEMPLATES;
$smarty->compile_dir   = TEMPLATES_C;
$smarty->plugins_dir[] = PLUGINS_DIR;
$smarty->caching       = false;
$smarty->trusted_dir  = TRUSTED_DIR;

$smarty->autoload_filters = array('post' => array('error','lang'));

?>
