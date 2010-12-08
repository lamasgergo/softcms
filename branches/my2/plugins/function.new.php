<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.obj.php
 * Type:     function
 * Name:     obj
 * Purpose:  creates object
 * -------------------------------------------------------------
 */
function smarty_function_new($params, $template)
{
    $class = strtolower($params['class']);
    $name = $params['name'];

    $root = realpath(dirname(__FILE__).'/../../');
    require_once($root."/modules/{$class}/{$class}.php");

    $obj = new $class();

    $template->assign($name, $obj);
}
?>