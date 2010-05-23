<?php

function smarty_function_grid($params){


    $class = $params['class'];
    $module = $params['module'];
    $method = 'getValue';
/*
    $classPath = $_SERVER['DOCUMENT_ROOT'] . "/admin/modules/" . strtolower($module) . "/" . strtolower($class) . ".php";
    
    if (!$module || !$class || !file_exists($classPath)) die('File not found');

    if (Access::check($module, 'show')) {
        include_once($classPath);
        if (class_exists($class)){
            $ajax = new $class($module);
            if (method_exists($ajax, $method)){
                $response = $ajax->$method();
            } else die('Method not exists');
        } else die('Class not exists');
    }
*/
$data = $params['data'];

$colNames = array();
$colModel = array();
foreach ($data[0] as $name=>$value){
    $colNames[] = Locale::get($class."_".$name);
    $sorttype = 'text';
    if ((int)($value) > 0) $sorttype = 'int';
    if (preg_match("/\d{2,4}[\.\-]+\d{2}[\.\-]+\d{2,4}/", $value)) $sorttype = 'date';
    $colModel[] = array(
        'name'  => $name,
        'index' => $name,
        'sorttype' => $sorttype
        );
}
$colNamesJS = json_encode($colNames);
$colModelJS = json_encode($colModel);

$html = '<table id="list" class="scroll">';
foreach ($data as $i=>$row){
    $html .= '<tr>';
    foreach ($row as $cell){
        $html .= '<td>';
        $html .= $cell;
        $html .= '</td>';
    }
    $html .= '</tr>';
}
$html .= '</table>';

$html .=<<<HTML

<div id="pager" class="scroll" style="text-align:center;"></div>

<script>
jQuery(document).ready(function(){
        var lastSel;
        jQuery("#list").jqGrid({
            datatype: 'html',
            colNames: {$colNamesJS},
            colModel : {$colModelJS},
            pager: jQuery('#pager'),
            rowNum:5,
            rowList:[2,5,10,30],
            viewrecords: true,
            imgpath: 'themes/basic/images',
            caption: 'base categories',
            ondblClickRow: function(id) {
                if (id && id != lastSel) {
                    jQuery("#list").restoreRow(lastSel);
                    jQuery("#list").editRow(id, true);
                    lastSel = id;
                }
            },
        });
    });
</script>
HTML;

    return $html;
}
?>