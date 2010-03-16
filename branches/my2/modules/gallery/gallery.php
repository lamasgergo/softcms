<?php
$mod_name = "gallery";

require_once(MODULES_DIR."/".$mod_name."/gallery.class.php");

$gallery = new Gallery($mod_name, $block_vars, $dynamic);
$output = $gallery->show();
?>