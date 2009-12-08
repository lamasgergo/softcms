<?php
$mod_name = $_GET[MODULE];

require_once(__PATH__."/admin/modules/".$mod_name."/categories.php");
require_once(__PATH__."/admin/modules/".$mod_name."/items.php");


$form = new Backend($mod_name);

$form->addObject(new Categories($mod_name),1);
$form->addObject(new Items($mod_name),2);

$parse_main = $form->show();
?>