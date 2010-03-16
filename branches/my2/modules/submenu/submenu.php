<?php
include_once(MODULES_DIR."/submenu/submenu.class.php");
$submenu = new SubMenu($block_vars,$dynamic);
$output = $submenu->show();
?>