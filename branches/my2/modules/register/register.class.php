<?php

require_once(MODULES_DIR."/".$mod_name."/registerform.php");

class Register{
	var $block_vars;
	var $dynamic;
	var $moduleName; // module name
	
	var $obj;

	var $backURL;
	var $register = false;
	var $edit = false;
	var $user;

	function Register($moduleName){
		$this->moduleName = $mod_name;
		
		$this->getVars();
		
		switch ($this->mode){
			case "form":
			default:
				$this->obj = new RegisterForm($this->moduleName, $this->backURL);
				if ($this->register){
					$this->register = $this->obj->register($_POST);
				}
				if ($this->edit){
					$this->obj->register($_POST);
				}
				break;
		}
	}
		
	function getVars(){
		global $user;
		$this->backURL = $_GET['back_url'];
		if (isset($_POST['reg_save_data']))	$this->register = true;
		if (isset($_GET['Edit']) && $user && $user->id)	$this->edit = true;
	}
	
	
	
	function show(){
		if ($this->register){
			echo '<script language="javascript">location.replace("'.$this->backURL.'");</script>';
		}
		return $this->obj->show();
	}
}
?>
