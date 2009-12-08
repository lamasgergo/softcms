<?php
$mod_name = "poll";

require_once(__PATH__."/admin/common/adminform.php");
require_once(__PATH__."/admin/modules/".$mod_name."/categories.php");
require_once(__PATH__."/admin/modules/".$mod_name."/items.php");


$form = new AdminForm($mod_name);

$form->addTabObject(new Categories($mod_name,0));
$form->addTabObject(new Items($mod_name,1));

$parse_main = $form->show();
?>