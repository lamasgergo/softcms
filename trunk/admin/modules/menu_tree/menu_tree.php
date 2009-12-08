<?php
$mod_name = "menu_tree";

require_once($_SERVER['DOCUMENT_ROOT']."/admin/common/adminform.php");
require_once($_SERVER['DOCUMENT_ROOT']."/admin/modules/".$mod_name."/menutree.php");


$form = new AdminForm($mod_name);

$form->addTabObject(new MenuTree($mod_name,1));

$parse_main = $form->show();


?>