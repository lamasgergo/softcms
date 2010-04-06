<?php
include_once(dirname(__FILE__).'/adodb/adodb.inc.php');
require_once(dirname(__FILE__).'/adodb/adodb-active-record.inc.php');

    $db = &ADONewConnection('mysql');
    ADOdb_Active_Record::SetDatabaseAdapter($db);
    $db->Connect(Settings::get('host'), Settings::get('user'), Settings::get('password'), Settings::get('database'));
    $db->setFetchMode(ADODB_FETCH_ASSOC);

    $db->Execute("SET NAMES 'utf8';");
?>