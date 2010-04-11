<?php

require_once(dirname(__FILE__)."/../../classes/TabView.php");
require_once(dirname(__FILE__)."/basecategories.php");
require_once(dirname(__FILE__)."/baseitems.php");

TabView::add(new BaseCategories());
TabView::add(new BaseItems());

$parse_main = TabView::show();

?>