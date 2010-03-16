<?php
$mod_name = "search";

if ($block_vars['tpl'] && !empty($block_vars['tpl'])){
	$output = $this->smarty->fetch("search/".$block_vars['tpl'].'.tpl', null, $this->language);
} else {
	include_once(MODULES_DIR."/search/search.class.php");
	$search = new Search($mod_name);
	$output = $search->show();
}
?>