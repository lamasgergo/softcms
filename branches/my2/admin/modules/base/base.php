<?php
$mod_name = "base";

require_once(__PATH__."/admin/common/adminform.php");
require_once(__PATH__."/admin/modules/".$mod_name."/basecategories.php");
require_once(__PATH__."/admin/modules/".$mod_name."/baseitems.php");


$form = new AdminForm($mod_name);

$form->addTabObject(new BaseCategories($mod_name,0));
$form->addTabObject(new BaseItems($mod_name,1));

$parse_main = $form->show();
?>