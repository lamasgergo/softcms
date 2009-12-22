<?php
$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__));
define("BACKEND", false);
session_start();
ini_set('display_errors','on');
error_reporting(2039);

include_once("config/config.php");
include_once($_SERVER['DOCUMENT_ROOT']."/kernel/init.php");


$page = new Page();
$page->display();
?>
