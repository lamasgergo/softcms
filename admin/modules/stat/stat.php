<?php
$mod_name = "stat";

require_once($_SERVER['DOCUMENT_ROOT']."/admin/common/adminform.php");
require_once($_SERVER['DOCUMENT_ROOT']."/admin/modules/".$mod_name."/statpages.php");

if ($_GET['clear']=='1'){
	$db->Execute('TRUNCATE bs_stat_pages;');
	echo '<script>location.replace("index.php?mod=stat");</script>';
}


$form = new AdminForm($mod_name);

$form->addTabObject(new StatPages($mod_name,1));

$parse_main = $form->show();
?>