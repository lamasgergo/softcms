<?php

require_once(dirname(__FILE__)."/../../classes/TabView.php");
require_once(dirname(__FILE__) . "/categories.php");
require_once(dirname(__FILE__) . "/items.php");

TabView::add(new Categories());
TabView::add(new Items());

$parse_main = TabView::show();

?>