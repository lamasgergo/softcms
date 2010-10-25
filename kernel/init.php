<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/kernel/Settings.php');
require_once($_SERVER['DOCUMENT_ROOT']."/kernel/ObjectRegistry.php");
Settings::loadFS();
require_once($_SERVER['DOCUMENT_ROOT']."/kernel/adodb.php");
session_start();
ObjectRegistry::getInstance()->set('db', $db);
Settings::load();
define('DB_PREFIX', Settings::get('database_prefix'));



require_once($_SERVER['DOCUMENT_ROOT']."/kernel/languageService.php");
require_once($_SERVER['DOCUMENT_ROOT']."/kernel/locale.php");

require_once($_SERVER['DOCUMENT_ROOT']."/kernel/smarty.php");
require_once($_SERVER['DOCUMENT_ROOT']."/kernel/User.php");
require_once($_SERVER['DOCUMENT_ROOT']."/kernel/Access.php");
require_once($_SERVER['DOCUMENT_ROOT']."/kernel/functions.php");
require_once($_SERVER['DOCUMENT_ROOT']."/kernel/Translit.php");

$smarty->template_dir  = $_SERVER['DOCUMENT_ROOT'].'/admin/templates';
ObjectRegistry::getInstance()->set('smarty', $smarty);

$user = User::getInstance();
ObjectRegistry::getInstance()->set('user', $user);

$user->isBackend(true);

//$obReg->set('language', $language);
//loadLangArr($lang,$language);




?>