<?php
$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__));

include_once(dirname(__FILE__)."/kernel/PageHelper.php");

$path = PageHelper::clearPath($_SERVER['REQUEST_URI']);
if (!strpos($path, "?")){
    $path = explode("/", $path);
    if (count($path) > 0){
        if ($path[count($path)-2]=='page'){
            $page = array_pop($path);
            $pageVar = array_pop($path);
            $_GET[$pageVar] = $page;
        }
        $_SERVER['REQUEST_URI'] = '/'.implode("/",$path);
    }
}

require_once(dirname(__FILE__).'/index.php');
?>