<?php
class RegisterForm{

  var $moduleName; // module name
  var $tpl; // tpl to show
  
  var $db;
  var $smarty;
  var $lang;
  var $language;
  var $langID;
  
  var $error;
  
  var $userData;
  
  
  function RegisterForm($moduleName, $backURL=''){
    global $smarty,$db,$lang,$language,$langID,$user;
    
    $this->moduleName = $mod_name;
    $this->db = $db;
    $this->smarty = $smarty;
    $this->lang = $lang;
    $this->language = $language;
    $this->LangID = $langID;
    $this->where = array();
    $this->tpl = 'reg.tpl';
	$this->user = &$user;
  }
  
  function register($data){
		$user_data = array(
			"login" => $data["reg_login"],
			"password" => $data["reg_password"],
			"password2" => $data["reg_password2"],
			"name" => $data["reg_name"],
			"email" => $data["reg_email"]
		);
	
	$this->userData = $user_data;
	
	$err_no = $this->add($user_data);	
	
	switch ($err_no){
		case 0:
			$this->error = $this->lang["reg_err_ok"];
			return true;
		break;	
		case 1:
			$this->error = $this->lang["reg_err_login"];
		break;	
		case 2:
			$this->error = $this->lang["reg_err_password"];
		break;	
		case 3:
			$this->error = $this->lang["reg_err_email"];
		break;	
		case 4:
			$this->error = $this->lang["reg_err_empty"];
		break;
		case 5:
			$this->error = $this->lang["reg_err_sql"];
		break;		
	}
	return false;
  }

  function check_login($login){
  	global $db;
  	$sql = $db->prepare("SELECT ID FROM ".DB_PREFIX."users WHERE Login='".$login."'");
  	$res = $db->Execute($sql);
  	if ($res && $res->RecordCount() > 0){
  		return 0;	
  	} else return 1;
  }
  
  function add($user_data){
  global $db;
	if (!$this->user->id && !$this->check_login($user_data["login"])){
		return 1;	
	}
	if ($user_data["password"]!=$user_data["password2"]){
		return 2;	
	}
	if (!preg_match("/^([\w\d\-\_]+[._]?){1,}[\w\d]+\@([\w\d\-]+)(\.[\w\d\-]+)*(\.[\w]{2,4})$/i",$user_data["email"])){
		return 3;	
	}
	foreach ($user_data as $key=>$val){
		if (empty($val)){
			return 4;	
		}
	}
	$password = $this->new_password($user_data["password"]);
	if ($this->user->id){
		$sql = "UPDATE bs_users SET Login='".$user_data["login"]."', `Password`='".$password."', Name='".$user_data["name"]."', Email='".$user_data["email"]."' WHERE ID='".$this->user->id."'";
	} else {
		$sql = $db->prepare("INSERT INTO ".DB_PREFIX."users(GroupID,LangID,Login,Password,Familyname,Name,Email) VALUES (0,1,'".$user_data["login"]."','".$password."','".$user_data["familyname"]."','".$user_data["name"]."','".$user_data["email"]."')");
	}
	if ($db->Execute($sql)){
		$this->user->auth($user_data["login"],$user_data["password"]);
		return 0;	
	} else return 5;
  }
  
  function new_password($password){
    return crypt($password,CRYPT_MD5);  
  }
  
  function show(){
  
	if ($this->user && $this->user->id){
		foreach ($this->user->data as $name=>$value){
			$this->userData[strtolower($name)] = $value;
		}
	}
  
	$this->smarty->assign("user_data",$this->userData);
  
	$this->smarty->assign("error",$this->error);
  	$this->smarty->assign("moduleName",$this->moduleName);
    return $this->smarty->fetch(strtolower($this->moduleName)."/".$this->tpl,null,$this->language);
  }
}
?>