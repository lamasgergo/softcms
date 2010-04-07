<?php

require_once(dirname(__FILE__)."/../../common/TabContainer.php");
require_once(dirname(__FILE__)."/basecategories.php");
require_once(dirname(__FILE__)."/baseitems.php");

TabContainer::add(new BaseCategories());
TabContainer::add(new BaseItems());

$parse_main = TabContainer::show();

?>