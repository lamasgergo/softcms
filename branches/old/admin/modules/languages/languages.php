<?php
$mod_name = "languages";

require_once($_SERVER['DOCUMENT_ROOT']."/admin/common/TabLayout.php");
require_once($_SERVER['DOCUMENT_ROOT']."/admin/modules/".$mod_name."/langlist.php");



$form = new TabLayout($mod_name);

$form->addTabObject(new LangList($mod_name,1));

$parse_main = $form->show();
?>