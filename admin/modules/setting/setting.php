<?php
$mod_name = "setting";

require_once(__PATH__."/admin/common/adminform.php");
require_once(__PATH__."/admin/modules/".$mod_name."/settinglist.php");


$form = new AdminForm($mod_name);

$form->addTabObject(new SettingList($mod_name,1));

$parse_main = $form->show();
?>