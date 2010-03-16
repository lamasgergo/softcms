<?php
$mod_name = "plot";

require_once(MODULES_DIR."/".$mod_name."/plot.class.php");

$Plot = new Plot($mod_name, $block_vars, $dynamic);
$output = $Plot->show();
?>