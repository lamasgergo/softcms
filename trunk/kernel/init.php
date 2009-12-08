<?php

include_once($_SERVER['DOCUMENT_ROOT']."/kernel/common.php");
//include_once($_SERVER['DOCUMENT_ROOT']."/kernel/lang.php");
include_once($_SERVER['DOCUMENT_ROOT']."/kernel/external/adodb.php");
include_once($_SERVER['DOCUMENT_ROOT']."/kernel/external/smarty.php");
require_once($_SERVER['DOCUMENT_ROOT']."/kernel/external/xajax.inc.php");

include_once($_SERVER['DOCUMENT_ROOT']."/kernel/user.class.php"); // load before languages
require_once($_SERVER['DOCUMENT_ROOT']."/kernel/classes/languages.php");
require_once($_SERVER['DOCUMENT_ROOT']."/kernel/classes/base.php");
require_once($_SERVER['DOCUMENT_ROOT']."/kernel/classes/ui.php");




$xajax = new xajax();



if (!is_admin()){
    include_once($_SERVER['DOCUMENT_ROOT']."/kernel/classes/modules.php");
    // autoload modules
    $modules->loadModules();
    include_once($_SERVER['DOCUMENT_ROOT']."/kernel/classes/page.php");
//    include_once($_SERVER['DOCUMENT_ROOT']."/kernel/meta.class.php");
//    include_once($_SERVER['DOCUMENT_ROOT']."/kernel/navigator.php");
//
//    $meta = new Meta();
    $smarty->register_object("db",$db);
//    $smarty->register_object("meta",$meta);
//    $smarty->assign("MODULE",MODULE);

}




?>