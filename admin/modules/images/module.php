<?php

require_once(dirname(__FILE__)."/../../classes/TabView.php");
require_once(dirname(__FILE__) . "/images.php");
require_once(dirname(__FILE__) . "/imagescategories.php");

TabView::add(new ImagesCategories());
TabView::add(new Images());

$parse_main = TabView::show();

?>