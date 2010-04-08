<?php
require_once dirname(__FILE__).'/../../kernel/Settings.php';
require_once dirname(__FILE__)."/../../kernel/ObjectRegistry.php";
Settings::loadFS();
require_once(dirname(__FILE__)."/../../kernel/adodb.php");
session_start();
ObjectRegistry::getInstance()->set('db', $db);
Settings::load();
define('DB_PREFIX', Settings::get('database_prefix'));



require_once(dirname(__FILE__)."/../../kernel/languageService.php");
require_once(dirname(__FILE__)."/../../kernel/locale.php");

require_once(dirname(__FILE__)."/../../kernel/smarty.php");
require_once(dirname(__FILE__)."/../../kernel/User.php");
require_once(dirname(__FILE__)."/../common/Access.php");
require_once(dirname(__FILE__)."/../common/functions.php");

$smarty->template_dir  = $_SERVER['DOCUMENT_ROOT'].'/admin/templates';
ObjectRegistry::getInstance()->set('smarty', $smarty);

$user = User::getInstance();
ObjectRegistry::getInstance()->set('user', $user);

Locale::setLang($language=$user->get('EditLang'));

$user->isBackend(true);

//$obReg->set('language', $language);
//loadLangArr($lang,$language);




?>