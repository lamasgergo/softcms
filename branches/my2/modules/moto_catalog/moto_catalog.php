<?php
$mod_name = "moto_catalog";

require_once(MODULES_DIR."/".$mod_name."/catalog.class.php");

$catalog = new Catalog($mod_name, $block_vars, $dynamic);
$output = $catalog->show();
?>