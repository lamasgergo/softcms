<?php
$mod_name = "register";

require_once(MODULES_DIR."/".$mod_name."/register.class.php");


if (isset($_GET['maillists'])){
	$output = $this->smarty->fetch('not_enabled.tpl',null,$this->language);
} else {
	$register = new Register($mod_name);
	$output = $register->show();
}
?>