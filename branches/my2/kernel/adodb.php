<?php
include_once(dirname(__FILE__).'/adodb/adodb.inc.php');
require_once(dirname(__FILE__).'/adodb/adodb-active-record.inc.php');

$settings = Configuration::getInstance();

$db = &ADONewConnection('mysql');
ADOdb_Active_Record::SetDatabaseAdapter($db);
$db->Connect($settings->get('host'), $settings->get('user'), $settings->get('password'), $settings->get('database'));
$db->setFetchMode(ADODB_FETCH_ASSOC);

$db->Execute("SET NAMES 'utf8';");

?>