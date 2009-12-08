<?php

class User{
    var $id;

    var $login;

    var $group_id;

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
        $sql = $this->db->prepare("SELECT ID, Login, Published, GroupID, Language FROM ".DB_PREFIX."users WHERE Login='".$login."' AND Password='".$password."' AND Published='1'");
        $res = $this->db->Execute($sql);
        if ($res && $res->RecordCount() > 0){
            $this->id = $res->fields['ID'];
            $this->login = $res->fields['Login'];
            $this->data = $res->fields;
            $this->lang->setLanguage($this->data['Language']);
            $this->startSession();
        } else{
            $_SESSION[SES_PREFIX."error"] = $this->lang->locale("login_wrong");
        }
    }

    function startSession(){
        $_SESSION[SES_PREFIX."id"] = $this->id;
    }

    function is_auth(){
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
