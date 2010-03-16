<?php
$mod_name = "languages";

require_once(__PATH__."/admin/common/adminform.php");
require_once(__PATH__."/admin/modules/".$mod_name."/langlist.php");



$form = new AdminForm($mod_name);

$form->addTabObject(new LangList($mod_name,1));

$parse_main = $form->show();
?>