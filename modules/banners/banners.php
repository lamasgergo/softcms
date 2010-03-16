<?php
$mod_name = "banners";

require_once(MODULES_DIR."/".$mod_name."/banners.class.php");

$banners = new Banners($mod_name, $block_vars, $dynamic);
$output = $banners->show();
?>