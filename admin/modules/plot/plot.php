<?php
$mod_name = "plot";

require_once($_SERVER['DOCUMENT_ROOT']."/admin/common/TabLayout.php");
require_once($_SERVER['DOCUMENT_ROOT']."/admin/modules/".$mod_name."/plots.php");


$form = new TabLayout($mod_name);

$form->addTabObject(new Plot($mod_name,0));

$parse_main = $form->show();
?>