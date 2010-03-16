<?php
include_once(MODULES_DIR."/menu_tree/menu.class.php");
$menu = new MenuTree($block_vars,$dynamic);
$output = $menu->show();
?>