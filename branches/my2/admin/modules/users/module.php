<?php

require_once(dirname(__FILE__)."/../../classes/TabView.php");
require_once(dirname(__FILE__) . "/users.php");

TabView::add(new Users());

$parse_main = TabView::show();

?>