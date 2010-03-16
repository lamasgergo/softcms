<?php
$mod_name = "catalog";


require_once(MODULES_DIR."/".$mod_name."/catalog.class.php");

$catalog = new Catalog($mod_name, $block_vars, $dynamic);
$output = $catalog->show();
?>