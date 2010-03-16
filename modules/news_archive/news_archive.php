<?
include_once(MODULES_DIR."/news_archive/content.class.php");
$cal = new Calendar($block_vars,$dynamic);
$output = $cal->show();

?>