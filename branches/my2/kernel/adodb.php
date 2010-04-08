<?php
include_once(dirname(__FILE__) . '/adodb/adodb.inc.php');
require_once(dirname(__FILE__) . '/adodb/adodb-active-record.inc.php');
require_once(dirname(__FILE__) . '/adodb/session/adodb-session2.php');

$db = ADONewConnection(Settings::get('driver'));
ADOdb_Active_Record::SetDatabaseAdapter($db);
$db->Connect(Settings::get('host'), Settings::get('user'), Settings::get('password'), Settings::get('database'));
$db->Execute("SET NAMES 'utf8';");
$db->SetFetchMode(ADODB_FETCH_ASSOC);
                    
$options['table'] = Settings::get('database_prefix').'sessions2';
ADOdb_Session::config(Settings::get('driver'), Settings::get('host'), Settings::get('user'), Settings::get('password'), Settings::get('database'), $options);

?>