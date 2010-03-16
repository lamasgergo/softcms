<?
require_once($_SERVER['DOCUMENT_ROOT'].'/config/config.php');
include_once(dirname(__FILE__).'/adodb/adodb.inc.php');
require_once(__LIBS__.'/adodb/adodb-active-record.inc.php');
$db = &ADONewConnection('mysql');
ADOdb_Active_Record::SetDatabaseAdapter($db);
$db->Connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$db->setFetchMode(ADODB_FETCH_ASSOC);

$db->Execute("SET NAMES '".DB_CHARSET."';");
?>