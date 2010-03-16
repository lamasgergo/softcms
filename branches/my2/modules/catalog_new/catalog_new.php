<?php
include_once(MODULES_DIR."/catalog_new/new.class.php");
$new = new CatalogNewItems($block_vars,$dynamic);
$output = $new->show();
?>