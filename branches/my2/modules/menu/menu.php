<?php
include_once(MODULES_DIR."/menu/menu.class.php");
$menu = new Menu($block_vars,$dynamic);
$output = $menu->show();
?>