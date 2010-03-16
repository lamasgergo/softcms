<?php
include_once(MODULES_DIR."/catalog_menu/menu.class.php");
$cmenu = new CatalogMenu($block_vars,$dynamic);
$output = $cmenu->show();
?>