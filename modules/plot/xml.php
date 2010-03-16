<?php
include_once(MODULES_DIR."/plot/plot.class.php");

$data = new Plot($block_vars,$dynamic);
echo $data->show();

?>