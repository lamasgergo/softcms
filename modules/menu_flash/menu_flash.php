<?php
include_once(MODULES_DIR."/menu_flash/menu_flash.class.php");
$menu_flash = new FlashMenu($block_vars,$dynamic);
$output = $menu_flash->show();
?>