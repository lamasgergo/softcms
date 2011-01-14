<?php
$mod_name = "setting";

require_once($_SERVER['DOCUMENT_ROOT']."/admin/common/TabLayout.php");
require_once($_SERVER['DOCUMENT_ROOT']."/admin/modules/".$mod_name."/settinglist.php");


$form = new TabLayout($mod_name);

$form->addTabObject(new SettingList($mod_name,1));

$parse_main = $form->show();
?>