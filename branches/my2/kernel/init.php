<?php
require_once(dirname(__FILE__).'/Settings.php');
Settings::loadFS();
require_once(dirname(__FILE__)."/adodb.php");
session_start();
Settings::load();
define('DB_PREFIX', Settings::get('database_prefix'));



require_once(dirname(__FILE__)."/languageService.php");
require_once(dirname(__FILE__)."/locale.php");

require_once(dirname(__FILE__)."/smarty.php");
require_once(dirname(__FILE__)."/User.php");
require_once(dirname(__FILE__)."/Access.php");
require_once(dirname(__FILE__)."/functions.php");
require_once(dirname(__FILE__)."/Translit.php");

$smarty->template_dir  = $_SERVER['DOCUMENT_ROOT'].'/admin/templates';

$user = User::getInstance();

$user->isBackend(true);

//$obReg->set('language', $language);
//loadLangArr($lang,$language);




?>