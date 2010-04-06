<?php
session_start();
include_once dirname(__FILE__).'/../../kernel/Settings.php';
include_once(dirname(__FILE__)."/../../kernel/ObjectRegistry.php");
Settings::loadFS();
include_once(dirname(__FILE__)."/../../kernel/adodb.php");
ObjectRegistry::getInstance()->set('db', $db);
Settings::load();
define('DB_PREFIX', Settings::get('database_prefix'));



include_once(dirname(__FILE__)."/../../kernel/languageService.php");
include_once(dirname(__FILE__)."/../../kernel/locale.php");

include_once(dirname(__FILE__)."/../../kernel/smarty.php");
include_once(dirname(__FILE__)."/../../kernel/User.php");
include_once(dirname(__FILE__)."/../common/Access.php");
include_once(dirname(__FILE__)."/../common/functions.php");

$smarty->template_dir  = $_SERVER['DOCUMENT_ROOT'].'/admin/templates';
ObjectRegistry::getInstance()->set('smarty', $smarty);

$user = User::getInstance();
ObjectRegistry::getInstance()->set('user', $user);

Locale::setLang($user->get('EditLang'));

$user->isBackend(true);

//$obReg->set('language', $language);
//loadLangArr($lang,$language);




?>