<?php
ini_set('display_errors', 1);
include_once(dirname(__FILE__).'/../' . "/kernel/init.php");

require_once(dirname(__FILE__) . '/classes/tabelement.php');

//$user = ObjectRegistry::getInstance()->get('user');
$user = User::getInstance();
if (!$user->isAuth()) die('Have no rights');

$class = '';
$module = '';
$method = '';
$id = '';
$action = '';
$response = '';

$moduleVarName = Settings::get('modules_varname');

if (isset($_GET[$moduleVarName])) $module = trim(urldecode($_GET[$moduleVarName]));
if (isset($_GET['class'])) $class = trim(urldecode($_GET['class']));
if (isset($_GET['method'])) $method = trim(urldecode($_GET['method']));
if (isset($_GET['action'])) $action = trim(urldecode($_GET['action']));
if (isset($_GET['id'])) $id = intval(urldecode($_GET['id']));

$classPath = $_SERVER['DOCUMENT_ROOT'] . "/admin/modules/" . strtolower($module) . "/" . strtolower($class) . ".php";
if (!$module || !$class || !file_exists($classPath)) die('File not found');

if (Access::check($module, 'show')) {
    include_once($classPath);
    if (class_exists($class)){
        $ajax = new $class($module);
        if (method_exists($ajax, $method)){
            if (isset($_POST) && count($_POST) > 0) {
                $response = $ajax->$method($_POST);
            } else {
                $response = $ajax->$method($action, $id);
            }
        } else die('Method not exists');
    } else die('Class not exists');
}

if (is_string($response)){
    echo $response;
} else {
    echo json_encode($response);
}

?>