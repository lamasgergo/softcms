<?php

class User{
    var $id;

    var $login;

    var $data;

    var $locale;

    function User(){
        global $db, $locale;
        $this->db = $db;
        $this->locale = $locale;
        $this->is_auth();
    }


    function auth($login, $password){
        $login = mysql_real_escape_string($login);
        $password = mysql_real_escape_string($password);
        $password = crypt($password,CRYPT_MD5);

        $sql = $this->db->prepare("SELECT ID FROM ".DB_PREFIX."users WHERE Login='".$login."' AND Password='".$password."' AND Published='1'");
        $res = $this->db->Execute($sql);
        if ($res && $res->RecordCount() > 0){
            $this->id = $res->fields['ID']; 
            $this->_startSession();
            $this->_getData();
        } else{
            $_SESSION[SES_PREFIX."error"] = $this->locale->translate("login_wrong");
        }
    }

    function _getData(){
        if (!isset($this->id) || $this->id <= 0) return false;
        
        $sql = $this->db->prepare("SELECT u.ID as userID, u.*, m.*  FROM ".DB_PREFIX."users as u LEFT JOIN ".DB_PREFIX."users_misc as m ON (u.ID=m.ID) WHERE u.ID='".$this->id."' AND u.Published='1'");
        $res = $this->db->Execute($sql);
        if ($res && $res->RecordCount() > 0){
            $this->id = $res->fields['userID'];
            $this->login = $res->fields['Login'];
            $this->data = $res->fields;

            $this->locale->setLanguage($res->fields['GUILang']);
        }
    }

    function _startSession(){
        $_SESSION[SES_PREFIX."id"] = $this->id;
    }

    function is_auth(){
        if (isset($_SESSION[SES_PREFIX."id"]) && $_SESSION[SES_PREFIX."id"] > 0){
            $this->id = $_SESSION[SES_PREFIX."id"];
            $this->_getData();
        }
        return (isset($this->id) && $this->id > 0);
    }

    function _clearSessions(){
        unset($_SESSION[SES_PREFIX."id"]);
        unset($this->id);
    }


    function _newPassword($password){
        return crypt($password,CRYPT_MD5);
    }

    function logout(){
        $this->_clearSessions();
        session_unregister($_SESSION[SES_PREFIX."id"]);
    }
}

$user = new User();
?>
