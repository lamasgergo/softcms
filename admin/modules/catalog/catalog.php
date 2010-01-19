<?php
$mod_name = "catalog";

require_once($_SERVER['DOCUMENT_ROOT']."/admin/common/TreeLayout.php");
require_once($_SERVER['DOCUMENT_ROOT']."/admin/common/BackendElement.php");
require_once($_SERVER['DOCUMENT_ROOT']."/admin/common/TreeElement.php");
require_once($_SERVER['DOCUMENT_ROOT']."/admin/modules/".$mod_name."/CatalogCategories.php");
require_once($_SERVER['DOCUMENT_ROOT']."/admin/modules/".$mod_name."/CatalogItems.php");

$tree = new TreeLayout($mod_name);
$tree->addCategories(new CatalogCategories($mod_name,0));
$tree->addContent(new CatalogItems($mod_name,1));

$tree->show();
?>