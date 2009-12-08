<?php
$mod_name = "gallery";

require_once($_SERVER['DOCUMENT_ROOT']."/admin/common/adminform.php");
require_once($_SERVER['DOCUMENT_ROOT']."/admin/modules/".$mod_name."/categories.php");
require_once($_SERVER['DOCUMENT_ROOT']."/admin/modules/".$mod_name."/items.php");


$form = new AdminForm($mod_name);

$form->addTabObject(new Categories($mod_name,0));
$form->addTabObject(new Items($mod_name,1));

$parse_main = $form->show();
?>