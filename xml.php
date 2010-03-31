<?
session_start();
header("Content-type: text/xml; charset=utf-8");

include_once("config/config.php");
include_once(__PATH__."/kernel/adodb.php");
include_once(__PATH__."/kernel/smarty.php");
include_once(__PATH__."/kernel/lang.php");
include_once(__PATH__."/kernel/user.class.php");
include_once(__PATH__."/kernel/page.php");
include_once(__PATH__."/kernel/common.php");
include_once(MODULES_DIR."/cart/cart.user.php");
include_once(__PATH__."/kernel/meta.class.php");
include_once(__PATH__."/kernel/navigator.php");

$smarty->assign("LangID",$LangID);
$smarty->assign("images",IMAGES_DIR);
$smarty->assign("css",CSS_DIR);
$smarty->assign("js",JS_DIR);

$cuser = new CartUser();
$meta = new Meta();
(isset($_GET[MODULE]) && !empty($_GET[MODULE])) ? $module = $_GET[MODULE] : $module = null;


$smarty->template_dir = $smarty->template_dir.'/xml';

$smarty->register_object("db",$db);
$smarty->register_object("meta",$meta);
$smarty->assign("has_reg_auth",$cuser->isAuth());
$smarty->assign("MODULE",MODULE);


include(MODULES_DIR.'/'.$module."/xml.php");

#$page->show();
?>
