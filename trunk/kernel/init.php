<?php

include_once($_SERVER['DOCUMENT_ROOT']."/kernel/common.php");
include_once($_SERVER['DOCUMENT_ROOT']."/kernel/external/adodb.php");
include_once($_SERVER['DOCUMENT_ROOT']."/kernel/external/smarty.php");
include_once($_SERVER['DOCUMENT_ROOT']."/kernel/external/xajax.inc.php");

include_once($_SERVER['DOCUMENT_ROOT']."/kernel/classes/languages.php");
include_once($_SERVER['DOCUMENT_ROOT']."/kernel/classes/user.php");

include_once($_SERVER['DOCUMENT_ROOT']."/kernel/classes/base.php");
include_once($_SERVER['DOCUMENT_ROOT']."/kernel/classes/modules.php");

$xajax = new xajax();


$smarty->register_object("db",$db);

if (!is_backend()){
    require_once($_SERVER['DOCUMENT_ROOT']."/kernel/classes/ui.php");
    // autoload modules
    $modules->loadModules();
    include_once($_SERVER['DOCUMENT_ROOT']."/kernel/classes/page.php");
} else {
    include_once($_SERVER['DOCUMENT_ROOT']."/admin/common/AdminLocale.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/admin/common/access.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/admin/common/adminpage.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/kernel/classes/QueryBuilder.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/admin/common/Backend.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/admin/common/adminform.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/admin/common/tabelement.php");
	
}




?>