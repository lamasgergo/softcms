<?
include_once($_SERVER['DOCUMENT_ROOT']."/admin/modules/manage/groups.php");
include_once($_SERVER['DOCUMENT_ROOT']."/admin/modules/manage/users.php");

$parse_main = $smarty->fetch('manage/manage.tpl', null, $language);
?>