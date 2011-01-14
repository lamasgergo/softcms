<?php
$mod_name = "site_banners";

require_once($_SERVER['DOCUMENT_ROOT']."/admin/common/TabLayout.php");
require_once($_SERVER['DOCUMENT_ROOT']."/admin/modules/".$mod_name."/sitebanners.php");
require_once($_SERVER['DOCUMENT_ROOT']."/admin/modules/".$mod_name."/sitebannersgroup.php");


$form = new TabLayout($mod_name);

$form->addTabObject(new SiteBannersGroup($mod_name,0));
$form->addTabObject(new SiteBanners($mod_name,1));

$parse_main = $form->show();
?>