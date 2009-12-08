<?
class User{
  var $reg = false;
  var $admin = false;
  var $id = "";
  var $group_id = "";
  var $name = "";
  var $familyname = "";
  var $lang_id = "";
  var $edit_lang_id = "";
  var $default_lang = "ru";
  var $is_backed = false;
  var $data;
  
  function User(){
    $this->is_auth();
  }
  
  
  function isBackend($val){
	$this->is_backed = (bool)$val;
  }
  
  function auth($login,$password, $backend = false){
  global $db,$lang;
	/*
    if ($this->is_backed){
        $sql = $db->prepare("SELECT g.Name as Name FROM ".DB_PREFIX."users as u LEFT JOIN ".DB_PREFIX."groups as g ON (g.ID=u.GroupID) WHERE u.Login='".$login."'");
        $res = $db->Execute($sql);
        if ($res && $res->RecordCount() > 0){
            if (strtolower($res->fields['Name'])!='admin' && $res->fields['GroupID']<=0){
                return false;
            }
        } else {
            return false;    
        }
    }
    */
    $sql = $db->prepare("SELECT ID, Login, Published, GroupID FROM ".DB_PREFIX."users WHERE Login='".$login."' AND Password='".crypt($password,CRYPT_MD5)."'");
	if ($this->is_backed){
		$sql .= " AND (GroupID>0 OR Login='admin')";
	}
	
    $res = $db->Execute($sql);
    if ($res && $res->RecordCount() > 0){
      if ($res->fields["Published"]=="1"){
        $this->reg = true;
        if ($res->fields["Login"]=="admin"){
          $this->admin = true;
          $_SESSION[SES_PREFIX."admin"]=true;
          $_SESSION[SES_PREFIX."id"]=$res->fields["ID"];
        } else {
          $this->admin = false;
          $_SESSION[SES_PREFIX."admin"]=false;
          $_SESSION[SES_PREFIX."id"]=$res->fields["ID"];
        }
        $_SESSION[SES_PREFIX."reg"]=true;
        $this->id = $res->fields["ID"];
        //$this->userdata();
      } else $_SESSION[SES_PREFIX."error"] = "login_blocked"; 
    } else{
      if (isset($lang["login_wrong"])){
          $_SESSION[SES_PREFIX."error"] = $lang["login_wrong"];  
      } else {
        $_SESSION[SES_PREFIX."error"] = "Please input correct login and password";  
      }
    }
  }
  
  function is_auth(){
  
    if (isset($_SESSION[SES_PREFIX."reg"])){
      $this->reg = (bool)$_SESSION[SES_PREFIX."reg"];
    }
    if (isset($_SESSION[SES_PREFIX."admin"])){
      $this->admin = $_SESSION[SES_PREFIX."admin"];
    }
    if (isset($_SESSION[SES_PREFIX."id"])){
      $this->id = $_SESSION[SES_PREFIX."id"];
    }
    $this->userdata();
	if ($this->is_backed && $this->group_id<=0){
		$this->clearSessions();
		return false;
	}
    return $this->reg;
  }

  function clearSessions(){
	unset($_SESSION[SES_PREFIX."reg"]);
	unset($_SESSION[SES_PREFIX."admin"]);
	unset($_SESSION[SES_PREFIX."id"]);
	unset($this->reg);
	unset($this->admin);
	unset($this->id);
  }
  
  function userdata(){
  global $db;
    $sql = $db->prepare("SELECT * FROM ".DB_PREFIX."users WHERE ID='".$this->id."'");
    $res = $db->Execute($sql);
    if ($res && $res->RecordCount() > 0){
	  $this->login = $res->fields["Login"];
      $this->name = $res->fields["Name"];
      $this->familyname = $res->fields["Familyname"];
      $this->lang_id = $res->fields["LangID"];
      $this->edit_lang_id = $res->fields["EditLangID"];
      $this->group_id = $res->fields["GroupID"];
	  $this->data = $res->fields;
    } 
  }
  
  function get_lang(){
  global $db;
    $lang = "";
    $sql = $db->prepare("SELECT Name FROM ".DB_PREFIX."lang WHERE ID='".$this->lang_id."'");  
    $res = $db->Execute($sql);
    if ($res && $res->RecordCount() > 0){
      $lang = $res->fields["Name"];
    } else $lang = $this->default_lang;
    return $lang;
  }
  function new_password($password){
    return crypt($password,CRYPT_MD5);  
  }
  
  function change_edit_lang($lang_id){
    global $db;
    $sql = $db->prepare("UPDATE ".DB_PREFIX."users SET EditLangID='".$lang_id."' WHERE ID='".$this->id."'");
    $db->Execute($sql);
    $this->edit_lang_id = $lang_id;
  }
  
  function logout(){
	$this->clearSessions();
	session_unregister($_SESSION[SES_PREFIX."reg"]);
	session_unregister($_SESSION[SES_PREFIX."admin"]);
	session_unregister($_SESSION[SES_PREFIX."id"]);
  }
}

$user = new User();
?>
