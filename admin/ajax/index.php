<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/config/config.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/admin/common/load.php");

require_once($_SERVER['DOCUMENT_ROOT'] . '/admin/common/tabelement.php');

if (!$user->is_auth()) die();

$class = '';
$module = '';
$method = '';
$id = '';
$action = '';

if (isset($_GET[MODULE])) $module = trim(urldecode($_GET[MODULE]));
if (isset($_GET['class'])) $class = trim(urldecode($_GET['class']));
if (isset($_GET['method'])) $method = trim(urldecode($_GET['method']));
if (isset($_GET['action'])) $action = trim(urldecode($_GET['action']));
if (isset($_GET['id'])) $id = intval(urldecode($_GET['id']));

$classPath = $_SERVER['DOCUMENT_ROOT'] . "/admin/modules/" . strtolower($module) . "/" . strtolower($class) . ".php";
if (!$module || !$class || !file_exists($classPath)) die();

if (check_show_rights()) {
    include_once($classPath);
    $ajax = new $class($module);
}

if (isset($_POST) && count($_POST) > 0){
    $response = $ajax->$method($_POST);
} else {
    $response = $ajax->$method($action, $id);
}

if (is_string($response)){
    echo $response;
} else {
    echo json_encode($response);
}




?>