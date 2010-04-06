<?php
$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__));

session_start();
ini_set('display_errors',1);
error_reporting(2039);

include_once("config/config.php");
include_once(__PATH__."/kernel/adodb.php");
include_once(__PATH__."/kernel/lang.php");
include_once(__PATH__."/kernel/smarty.php");


include_once(__PATH__."/kernel/User.php");
include_once(__PATH__."/kernel/cart.class.php");
include_once(__PATH__."/kernel/page.php");
include_once(__PATH__."/kernel/common.php");
include_once(__PATH__."/kernel/meta.class.php");
include_once(__PATH__."/kernel/navigator.php");
include_once(__PATH__."/modules/helpers/LinkHelper.php");

if (ROOT_REDIRECT!='' && $_SERVER['REQUEST_URI']=='/'){
	header('Location: '.ROOT_REDIRECT);
}


$smarty->assign("cur_lang",$language);
$smarty->assign("LangID",$LangID);
$smarty->assign("images",IMAGES_DIR);
$smarty->assign("css",CSS_DIR);
$smarty->assign("js",JS_DIR);


$meta = new Meta();
(isset($_GET[MODULE]) && !empty($_GET[MODULE])) ? $module = $_GET[MODULE] : $module = null;


$page = new Page($module);

if ((isset($_POST["reg_auth"]) && isset($_POST["logout"])) || isset($_GET['logout'])){
  $user->logout();
  if (isset($_SERVER['HTTP_REFERER'])){
	header("Location: ".$_SERVER['HTTP_REFERER']);
  }
}
if (isset($_POST["reg_auth"]) && !isset($_POST["logout"])){
  $user->auth($_POST["reg_login"],$_POST["reg_password"]);
}


if (isset($_POST["send_request"]) && isset($_POST["send_request"])){
  send_request($_POST);
}


$smarty->register_object("db",$db);
$smarty->register_object("meta",$meta);
$smarty->assign("has_reg_auth",$user->is_auth());
$smarty->assign("isAuth",$user->is_auth());
$smarty->assign("user_login",$user->login);
$smarty->assign("user_id",$user->id);
$smarty->assign("user_name", $user->name);
$smarty->assign("user_familyname", $user->familyname);
$smarty->assign("MODULE",MODULE);


$page->prepareOutput();

$smarty->assign("meta_title", $meta->meta_title);
$smarty->assign("meta_description", $meta->meta_description);
$smarty->assign("meta_keywords", $meta->meta_keywords);
$smarty->assign("meta_alt", $meta->meta_alt);


function getImage(){
	global $db, $smarty;
		$image1 = '';
		$image2 = '';
		$sql = $db->prepare("SELECT Image, Image2 FROM ".DB_PREFIX."menutree WHERE ID='".$_GET['menuId']."'");
		$res = $db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			$image1 = $res->fields['Image'];
			$image2 = $res->fields['Image2'];
			
		}
		$smarty->assign("header_image", $image1);
		$smarty->assign("left_image", $image2);
}

getImage();



$smarty->assign("menu", $menu);
				
$page->show();
/*
$fh = fopen($cache_file, 'w');
	if (filesize($cache_file)==0){
		$filesize = '1';
	} else $filesize = filesize($cache_file);
	fwrite($fh, serialize($langs));
	fclose($fh);
*/
?>
