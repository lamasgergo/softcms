<?
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     postfilter.lang.php
 * Type:     postfilter
 * Name:     lang
 * Version:  1.0
 * Date:     August 12, 2002
 * Purpose:  Parses the intermediate tags left by compiler.lang
 *           and replaces them with the translated strings,
 *           according to the $compile_id value (language code).
 *          
 * Install:  Drop into the plugin directory, call
 *           $smarty->load_filter('post','lang');
 *            or
 *           $smarty->autoload_filters = array('post' => array('lang'));
 *           from application.
 * Author:   Alejandro Sarco <ale@sarco.com.ar>
 * -------------------------------------------------------------
 */
function smarty_postfilter_lang($tpl, &$smarty) {
    global $lang;

    $locale = $lang->getLocale();

    $tpl = preg_replace('/\<\?\w+\s+\(\$lang\.([\w\d\_\-]+)\)\s+\?\>/iu',"###\\1###",$tpl);

    preg_match_all('/\#\#\#([\w\d\_\-]+)\#\#\#/iu',$tpl,$res);
    for ($i=0;$i<count($res[1]);$i++) {
        if ($locale[$res[1][$i]]){
            $tpl = preg_replace('/\#\#\#'.$res[1][$i].'\#\#\#/iu',$locale[$res[1][$i]],$tpl);
        } else $tpl = preg_replace('/\#\#\#'.$res[1][$i].'\#\#\#/iu',$res[1][$i],$tpl);
    }

    return $tpl;

}

?>
