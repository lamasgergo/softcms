<?php
$mod_name = "content";

require_once($_SERVER['DOCUMENT_ROOT']."/admin/common/TabLayout.php");
require_once($_SERVER['DOCUMENT_ROOT']."/admin/modules/".$mod_name."/categories.php");
require_once($_SERVER['DOCUMENT_ROOT']."/admin/modules/".$mod_name."/items.php");


$form = new TabLayout($mod_name);

$form->addTabObject(new Categories($mod_name,0));
$form->addTabObject(new Items($mod_name,1));

$parse_main = $form->show();
?>