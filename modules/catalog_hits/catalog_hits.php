<?php
include_once(MODULES_DIR."/catalog_hits/hits.class.php");
$hits = new CatalogHits($block_vars,$dynamic);
$output = $hits->show();
?>