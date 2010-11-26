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
function smarty_function_obj($params, $template)
{
    $class = strtolower($params['class']);
    $name = $params['name'];

    $root = realpath(dirname(__FILE__).'/../../');
    include_once($root."/modules/{$class}/{$class}.php");

    $$name = new $class();
    $template->register_object($name, $$name);
}
?>