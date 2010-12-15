<?php
class User {

    private $backend_groups = array('administrators', 'managers', 'editors');
    private $backend;
    private $db;
    private $data;
    private $id;
    private static $instance;
    private $table;

    private static $USER_SESSION_PREFIX = 'my_';

    private function __construct() {
        global $db;
        $this->db = $db;
        $this->table = DB_PREFIX . 'users';
        $this->restoreSession();
        $this->getDetail();
    }


    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new User();
        }
        return self::$instance;
    }


    public function login($login, $password, $backend = false) {
        $this->backend = $backend;

        $passwd = crypt($password, CRYPT_MD5);

        $query = $this->db->prepare("SELECT ID, Login, Published, `Group` FROM {$this->table} WHERE Login='{$login}' AND Password='{$passwd}' AND Published='1'");
        if ($this->backend) {
            $query .= " AND `Group` IN ('" . implode("','", $this->backend_groups) . "')";
        }
        $res = $this->db->Execute($query);
        if ($res && $res->RecordCount() > 0) {
            $this->id = $res->fields['ID'];
            $this->getDetail();
            $this->setSession();
            return true;
        }
        return false;
    }

    private function getDetail() {
        $query = $this->db->prepare("SELECT `ID`, `Login`, `Lang`, `Group`, `Name`, `Email`, `Published`, `EditLang` FROM {$this->table} WHERE ID='{$this->id}'");
        $res = $this->db->Execute($query);
        if ($res && $res->RecordCount() > 0) {
            $data = $res->GetArray();
            if (!isset($data[0])) $data[0] = array();
            $this->data = $data[0];
        }
    }

    public function isBackend($val) {
        $this->backend = (bool) $val;
    }

    private function restoreSession() {
        if (isset($_SESSION[self::$USER_SESSION_PREFIX . "id"])) {
            return $this->id = $_SESSION[self::$USER_SESSION_PREFIX . "id"];
        }
        return null;
    }

    private function setSession() {
        if (isset($this->id) && $this->id > 0) {
            $_SESSION[self::$USER_SESSION_PREFIX . "id"] = $this->id;
        }
    }

    public function isAuth() {
        if ($this->id && $this->id > 0) return true;
        return false;
    }

    public function logout() {
        if (isset($_SESSION[self::$USER_SESSION_PREFIX . "id"])) {
            unset($_SESSION[self::$USER_SESSION_PREFIX . "id"]);
        }
    }

    public function isAdmin() {
        if ($this->get('Group') == 'administrators') return true;
        return false;
    }

    public function get($param) {
        if (isset($this->data[$param])) return $this->data[$param];
        return '';
    }

    public function getData() {
        return $this->data;
    }

    public function set($param, $value) {
        $this->data[$param]=$value;
        $param = $this->db->escape($param);
        $value = $this->db->escape($value);
        $query = $this->db->Prepare("UPDATE {$this->table} SET `$param`='{$value}' WHERE ID='{$this->id}'");
        if ($this->db->Execute($query)){
            return true;
        }
        return false;
    }
}

?>
