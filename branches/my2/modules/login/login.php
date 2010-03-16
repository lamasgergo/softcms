<?php

$moduleName = 'login';


if (file_exists($this->smarty->template_dir."/".strtolower($moduleName)."/".$block_vars['tpl'].'.tpl')){
	$output = $this->smarty->fetch($this->smarty->template_dir."/".strtolower($moduleName)."/".$block_vars['tpl'].'.tpl',null,$this->language);
} else {
	$output = $this->smarty->fetch("login/login.tpl",null,$this->language);
}

?>