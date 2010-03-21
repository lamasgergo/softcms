<?php
class User {

    var $backend_groups = array('administrators', 'managers', 'editors');
    var $backend;
    var $db;
    var $data;
    var $id;

    function User() {
        global $db;
        $this->db = &$db;
        $this->is_auth();
    }

    function login($login, $password, $backend=false){
        $this->backend = $backend;
        
        $passwd = crypt($password, CRYPT_MD5);

        $query = $this->db->prepare("SELECT ID, Login, Published, `Group` FROM " . DB_PREFIX . "users WHERE Login='" . $login . "' AND Password='" . $passwd . "' AND Published='1'");
        if ($this->backend) {
            $query .= " AND `Group` IN ('".implode("','", $this->backend_groups)."')";
        }
        $res = $this->db->Execute($query);
        if ($res && $res->RecordCount() > 0) {
            $this->id = $res->fields['ID'];
            $this->data = $this->getData();
            $this->setSession();
        }
    }

    function getData(){
        $query = $this->db->prepare("SELECT ID, Login, `Group`, Name, Familyname, Email, Country, ZIP, City, Address, EditLang, Phone, Cellphone FROM " . DB_PREFIX . "users WHERE ID='" . $this->id . "'");
        $res = $this->db->Execute($query);
        if ($res && $res->RecordCount() > 0) {
            $data = $res->getArray();
            if (!isset($data[0])) $data[0] = array();
            $this->data = $data[0];
        }
        return $this->data;
    }

    function isBackend($val) {
        $this->backend = (bool) $val;
    }

    function setSession() {
        if (isset($this->id) && $this->id > 0){
            $_SESSION[SES_PREFIX . "id"] = $this->id;
        }
    }

    function is_auth() {
        if (isset( $_SESSION[SES_PREFIX . "id"]) &&  $_SESSION[SES_PREFIX . "id"] > 0){
            $this->id =  $_SESSION[SES_PREFIX . "id"];
            $this->data = $this->getData();
            return true;
        }
        return false;
    }

    function logout() {
        unset($_SESSION[SES_PREFIX . "id"]);
        session_unregister($_SESSION[SES_PREFIX . "id"]);
    }

    function get_lang(){
        return $this->data['EditLang'];
    }

    function is_admin(){
        if ($this->get('Group')=='administrators') return true;
        return false;
    }

    function get($param){
        if (isset($this->data[$param])) return $this->data[$param];
        return '';
    }
}

$user = new User();
?>
