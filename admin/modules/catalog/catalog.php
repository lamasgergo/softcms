<?php
$mod_name = "catalog";

require_once($_SERVER['DOCUMENT_ROOT']."/admin/common/TreeLayout.php");
require_once($_SERVER['DOCUMENT_ROOT']."/admin/common/BackendElement.php");
require_once($_SERVER['DOCUMENT_ROOT']."/admin/common/TreeElement.php");
require_once($_SERVER['DOCUMENT_ROOT']."/admin/modules/".$mod_name."/categories.php");
require_once($_SERVER['DOCUMENT_ROOT']."/admin/modules/".$mod_name."/items.php");

$tree = new TreeLayout($mod_name);

$tree->addCategories(new Categories($mod_name,0));
$tree->addContent(new Items($mod_name,1));

$parse_main = $tree->show();
?>