<?php
$mod_name = "site_banners";

require_once(__PATH__."/admin/common/adminform.php");
require_once(__PATH__."/admin/modules/".$mod_name."/sitebanners.php");
require_once(__PATH__."/admin/modules/".$mod_name."/sitebannersgroup.php");


$form = new AdminForm($mod_name);

$form->addTabObject(new SiteBannersGroup($mod_name,0));
$form->addTabObject(new SiteBanners($mod_name,1));

$parse_main = $form->show();
?>