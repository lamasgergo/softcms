<?php

class User{
    var $id;

    var $login;

    var $lang;

    var $data;

    function User(){
        global $db, $lang;
        $this->db = $db;
        $this->lang = $lang;
        $this->is_auth();
    }


    function auth($login, $password){
        $login = mysql_real_escape_string($login);
        $password = mysql_real_escape_string($password);
        $password = crypt($password,CRYPT_MD5);

        $sql = $this->db->prepare("SELECT ID, Login, Published, Language FROM ".DB_PREFIX."users WHERE Login='".$login."' AND Password='".$password."' AND Published='1'");
        $res = $this->db->Execute($sql);
        if ($res && $res->RecordCount() > 0){
            $this->id = $res->fields['ID']; 
            $this->lang->setLanguage($res->fields['Language']);
            $this->startSession();
            $this->getData();
        } else{
            $_SESSION[SES_PREFIX."error"] = $this->lang->locale("login_wrong");
        }
    }

    function getData(){
        if (!isset($this->id) || $this->id <= 0) return false;
        
        $sql = $this->db->prepare("SELECT u.*, g.Name as `Group`  FROM ".DB_PREFIX."users as u LEFT JOIN ".DB_PREFIX."groups as g ON (g.ID=u.GroupID) WHERE u.ID='".$this->id."' AND u.Published='1'");
        $res = $this->db->Execute($sql);
        if ($res && $res->RecordCount() > 0){
            $this->id = $res->fields['ID'];
            $this->login = $res->fields['Login'];
            $this->data = $res->fields;
        }
    }

    function startSession(){
        $_SESSION[SES_PREFIX."id"] = $this->id;
    }

    function is_auth(){
        if (isset($_SESSION[SES_PREFIX."id"]) && $_SESSION[SES_PREFIX."id"] > 0){
            $this->id = $_SESSION[SES_PREFIX."id"];
            $this->getData();
        }

        return (isset($this->id) && $this->id > 0);
    }

    function clearSessions(){
        unset($_SESSION[SES_PREFIX."id"]);
        unset($this->id);
    }


    function new_password($password){
        return crypt($password,CRYPT_MD5);
    }

    function change_lang($lang){
        $sql = $this->db->prepare("UPDATE ".DB_PREFIX."users SET Language='".$lang."' WHERE ID='".$this->id."'");
        $this->db->Execute($sql);
        $this->data['Language'] = $lang;
    }

    function logout(){
        $this->clearSessions();
        session_unregister($_SESSION[SES_PREFIX."id"]);
    }
}

$user = new User();
?>
