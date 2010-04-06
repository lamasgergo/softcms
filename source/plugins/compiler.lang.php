<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     compiler.lang.php
 * Type:     compiler function
 * Name:     lang
 * Version:  1.0
 * Date:     August 12, 2002
 * Purpose:  Transform the {lang} tags into intermediate tags
 *           to be read by postfilter.lang
 *          
 *
 * Example:  {lang Select}
 *    Will replace the tag with the translated string for "Select",
 *    taken from a translation string definition file.
 *        
 * Install:  Just drop into the plugin directory.
 *          
 * Author:   Alejandro Sarco <ale@sarco.com.ar>
 * -------------------------------------------------------------
 */
 
function smarty_compiler_lang ($params, &$smarty) {
 return "($"."lang.".$params.")";
 
}
?>
