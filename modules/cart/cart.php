<?php
	$mod_name = "cart";
	include_once(MODULES_DIR."/cart/cart.class.php");
	$cartmod = new CartModule($mod_name, $block_vars, $dynamic);
	$output = $cartmod->show();
?>