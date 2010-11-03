<?php

require_once(dirname(__FILE__)."/../../classes/TabView.php");
require_once(dirname(__FILE__) . "/pages.php");

TabView::add(new Pages());

$parse_main = TabView::show();

?>