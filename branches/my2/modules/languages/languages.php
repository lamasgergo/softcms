<?php
include_once(MODULES_DIR."/languages/languages.class.php");
$languages = new Languages($block_vars,$dynamic);
$output = $languages->show();
?>