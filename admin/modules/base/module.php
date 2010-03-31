<?php
$mod_name = 'base';

require_once(dirname(__FILE__)."/../../common/adminform.php");
require_once(dirname(__FILE__)."/basecategories.php");
require_once(dirname(__FILE__)."/baseitems.php");

AdminForm::addTab(new BaseCategories($mod_name));
AdminForm::addTab(new BaseItems($mod_name));

$parse_main = AdminForm::showTabs($mod_name);

?>