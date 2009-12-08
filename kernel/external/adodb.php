<?
include_once(dirname(__FILE__).'/adodb/adodb.inc.php');
require_once(dirname(__FILE__).'/adodb/adodb-active-record.inc.php');
$db = &ADONewConnection('mysql');
ADOdb_Active_Record::SetDatabaseAdapter($db);
$db->Connect($config->DB_HOST, $config->DB_USER, $config->DB_PASS, $config->DB_NAME);
$db->setFetchMode(ADODB_FETCH_ASSOC);

$db->Execute("SET NAMES '".$config->DB_CHARSET."';");

define('DB_PREFIX', $config->DB_PREFIX);
?>