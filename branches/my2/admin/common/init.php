<?php
session_start();
include_once(dirname(__FILE__).'/../../kernel/Configuration.php');
include_once(dirname(__FILE__)."/../../kernel/ObjectRegistry.php");
include_once(dirname(__FILE__)."/../../kernel/adodb.php");
$obReg = ObjectRegistry::getInstance();
$obReg->set('db', $db);
include_once dirname(__FILE__).'/../../kernel/Settings.php';
define('DB_PREFIX', Settings::getInstance()->get('database_prefix'));

include_once(dirname(__FILE__)."/../../kernel/lang.php");
include_once(dirname(__FILE__)."/../../kernel/smarty.php");
include_once(dirname(__FILE__)."/../../kernel/user.class.php");

$smarty->template_dir  = $_SERVER['DOCUMENT_ROOT'].'/admin/templates';
$obReg->set('smarty', $smarty);

$user = User::getInstance();
$obReg->set('user', $user);
$language = $user->get('EditLang');

$user->isBackend(true);

$obReg->set('language', $language);
loadLangArr($lang,$language);

include_once(dirname(__FILE__)."/../common/Access.php");
include_once(dirname(__FILE__)."/../common/functions.php");
include_once(dirname(__FILE__)."/../../kernel/locale.php");
include_once(dirname(__FILE__)."/../../kernel/Settings.php");


$locale = new Locale();
$obReg->set('locale', $locale);

?>