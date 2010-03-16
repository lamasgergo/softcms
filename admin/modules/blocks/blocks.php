<?php
$mod_name = "blocks";

require_once(__PATH__."/admin/common/adminform.php");
require_once(__PATH__."/admin/modules/".$mod_name."/blocksmanager.php");
require_once(__PATH__."/admin/modules/".$mod_name."/blockvars.php");


$form = new AdminForm($mod_name);

$form->addTabObject(new BlocksManager($mod_name,0));
$form->addTabObject(new BlockVars($mod_name,1));

$parse_main = $form->show();

?>