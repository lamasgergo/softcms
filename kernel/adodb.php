<?php
include_once(dirname(__FILE__) . '/../lib/vendor/adodb/adodb.inc.php');
include_once(dirname(__FILE__) . '/../lib/vendor/adodb/drivers/adodb-mysql.inc.php');
//require_once(dirname(__FILE__) . '/adodb/adodb-active-record.inc.php');
require_once(dirname(__FILE__) . '/../lib/vendor/adodb/session/adodb-session2.php');

//$db = ADONewConnection(Settings::get('driver'));
$db = new ADODB_mysql();
//ADOdb_Active_Record::SetDatabaseAdapter($db);
$db->Connect(Settings::get('host'), Settings::get('user'), Settings::get('password'), Settings::get('database'));
$db->Execute("SET NAMES 'utf8';");
$db->SetFetchMode(ADODB_FETCH_ASSOC);

$options['table'] = Settings::get('database_prefix') . 'sessions2';
ADOdb_Session::config(Settings::get('driver'), Settings::get('host'), Settings::get('user'), Settings::get('password'), Settings::get('database'), $options);

$ADODB_SESSION_EXPIRE_NOTIFY = array('USERID', 'NotifyFn');

function NotifyFn($expireref, $sesskey) {
    global $ADODB_SESS_CONN; # the session connection object
    $user = $ADODB_SESS_CONN->qstr($expireref);
    echo $user;
    //		$ADODB_SESS_CONN->Execute("delete from shopping_cart where user=$user");
    //		system("rm /work/tmpfiles/$expireref/*");
}

?>