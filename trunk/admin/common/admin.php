<?

require_once(__LIBS__."/xajax.inc.php");
$xajax = new xajax();
#$xajax->errorHandlerOff();
#$xajax->debugOn();

$xajax->registerFunction("check_rights");

/* menu */
include_once(__PATH__."/admin/common/menu.php");


if (preg_match("/^(\w+)\|(\w+)$/ui", $_GET[MODULE], $matches)){
	$module = $matches[1];
	$lib = strtolower($matches[2]);

	$_GET[MODULE] = $module;
	if (isset($module) && isset($lib) && file_exists(__PATH__."/admin/modules/".$module."/".$lib.".php")){
	  if (check_show_rights()){
		include_once(__PATH__."/admin/modules/".$module."/".$lib.".php");
		loadModuleLocale($_GET[MODULE], $language);
		$lib = ucfirst($lib);
		$class = new $lib($module);
		$smarty->assign("BODY", $class->show());
		$smarty->display('templates/ajax.tpl');
	  } 
	}
	exit();
}


if (isset($_GET[MODULE]) && file_exists(__PATH__."/admin/modules/".$_GET[MODULE]."/".$_GET[MODULE].".php")){
  if (check_show_rights()){
  	loadModuleLocale($_GET[MODULE], $language);
    include_once(__PATH__."/admin/modules/".$_GET[MODULE]."/".$_GET[MODULE].".php");
  } else {
    include_once(__PATH__."/admin/common/dashboard.php");
  }
} else {
  /* admin mainpage*/
  include_once(__PATH__."/admin/common/dashboard.php");
}


$smarty->assign("MENU",$parse_menu);
$smarty->assign("BODY",$parse_main);


$xajax->processRequests();
$smarty->assign("xajax_js",$xajax->getJavascript(JS_DIR."/xajax/","xajax.js"));

$smarty->display('templates/admin.tpl', null, $language);


function check_show_rights(){
  global $lang,$user,$db;
  $ret = true;
  $module = $_GET[MODULE];
  if (!$user->admin){
    $sql = $db->prepare("SELECT r.IsShow as IsShow FROM ".DB_PREFIX."modules_rights as r LEFT JOIN ".DB_PREFIX."modules as m ON (m.ID=r.ModuleID) WHERE r.UserID='".$user->id."'  AND m.Link='".$module."' GROUP BY r.ModuleID");
    $res = $db->Execute($sql);
    if ($res && $res->RecordCount() > 0){
      if ($res->fields["IsShow"]=="0") $ret = false;
    } else {
      $sql = $db->prepare("SELECT r.IsShow as IsShow FROM ".DB_PREFIX."modules_rights as r LEFT JOIN ".DB_PREFIX."modules as m ON (m.ID=r.ModuleID) WHERE r.GroupID='".$user->group_id."' AND m.Link='".$module."' GROUP BY r.ModuleID");
      $res = $db->Execute($sql);
      if ($res && $res->RecordCount() > 0){
        if ($res->fields["IsShow"]=="0") $ret = false;
      }
    }
  } else $ret = true;
  if ($ret==false) echo "<script language='Javascript'>alert('".$lang["per_cant_show"]."');</script>";
  return $ret;
}


function check_rights($action){
  global $lang,$user,$db;
  $ret = false;
  $module = $_GET[MODULE];
  $action = ucfirst($action);

  if (!$user->admin){
    $sql = $db->prepare("SELECT r.Is".$action." as Perm FROM ".DB_PREFIX."modules_rights as r LEFT JOIN ".DB_PREFIX."modules as m ON (m.ID=r.ModuleID) WHERE r.UserID='".$user->id."' AND m.Link='".$module."' GROUP BY r.ModuleID");
    $res = $db->Execute($sql);
    if ($res && $res->RecordCount() > 0){
      if ($res->fields["Perm"]=="1") $ret = true;
    } else {
      $sql = $db->prepare("SELECT r.Is".$action." as Perm FROM ".DB_PREFIX."modules_rights as r LEFT JOIN ".DB_PREFIX."modules as m ON (m.ID=r.ModuleID) WHERE r.GroupID='".$user->group_id."' AND m.Link='".$module."' GROUP BY r.ModuleID");
      $res = $db->Execute($sql);
      if ($res && $res->RecordCount() > 0){
        if ($res->fields["Perm"]=="1") $ret = true;
      }
    }
  } else{
    $ret = true;
  }
  return $ret;
}

function loadModuleLocale($module, $language){
	global $lang;
	if (file_exists(__PATH__.'/admin/modules/'.$module.'/locale/'.$language.'/')){
	  $lang_dir = dir(__PATH__.'/admin/modules/'.$module.'/locale/'.$language.'/');
	  while (false !== ($lang_file = $lang_dir->read())) {
	    if ($lang_file != '.' && $lang_file !='..' && preg_match("/.*\.php/",$lang_file)){
	      include_once($lang_dir->path.$lang_file);
	    }
	  }
	  $lang_dir->close();
	}
}

?>
