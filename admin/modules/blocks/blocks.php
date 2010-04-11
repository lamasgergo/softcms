<?php
$mod_name = "blocks";

require_once(__PATH__."/admin/common/TabView.php");
require_once(__PATH__."/admin/modules/".$mod_name."/blocksmanager.php");
require_once(__PATH__."/admin/modules/".$mod_name."/blockvars.php");


$form = new TabView($mod_name);

$form->addTabObject(new BlocksManager($mod_name,0));
$form->addTabObject(new BlockVars($mod_name,1));

$parse_main = $form->show();

?>