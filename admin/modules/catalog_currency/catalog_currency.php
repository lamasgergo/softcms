<?php
$mod_name = "catalog_currency";

require_once(__PATH__."/admin/common/adminform.php");
require_once(__PATH__."/admin/modules/".$mod_name."/currency.php");


$form = new AdminForm($mod_name);

$form->addTabObject(new Currency($mod_name,0));

$parse_main = $form->show();
?>