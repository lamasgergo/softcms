<?php
include_once(dirname(__FILE__) . '/../lib/vendor/adodb/adodb.inc.php');


class DB{

    public $databaseType = 'mysql';
	public $dataProvider = 'mysql';
    public $connection;

    private static $instance;

    private function __construct(){
        $this->connection =& NewADOConnection(Settings::get('driver'));
        $this->Connect(Settings::get('host'), Settings::get('user'), Settings::get('password'), Settings::get('database'));
        $this->connection->Execute("SET NAMES 'utf8';");
        $this->connection->SetFetchMode(ADODB_FETCH_ASSOC);
    }

    public static function getInstance(){
        if (!isset(self::$instance)) {
            self::$instance = new DB();
        }
    }   

    public function Connect($host, $user, $password, $database){
        $this->Connect($host, $user, $password, $database);
    }

    public function Execute($sql, $inputarr=false){
        return $this->connection->Execute($sql, $inputarr=false);
    }

    public function Prepare(){

    }
}

//
//$options['table'] = Settings::get('database_prefix') . 'sessions2';
//ADOdb_Session::config(Settings::get('driver'), Settings::get('host'), Settings::get('user'), Settings::get('password'), Settings::get('database'), $options);
//
//$ADODB_SESSION_EXPIRE_NOTIFY = array('USERID', 'NotifyFn');
//
//function NotifyFn($expireref, $sesskey) {
//    global $ADODB_SESS_CONN; # the session connection object
//    $user = $ADODB_SESS_CONN->qstr($expireref);
//    echo $user;
//    //		$ADODB_SESS_CONN->Execute("delete from shopping_cart where user=$user");
//    //		system("rm /work/tmpfiles/$expireref/*");
//}

?>