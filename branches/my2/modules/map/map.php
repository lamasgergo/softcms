<?php
include_once(MODULES_DIR."/map/map.class.php");
$map = new Map($block_vars,$dynamic);
$output = $map->show();
?>