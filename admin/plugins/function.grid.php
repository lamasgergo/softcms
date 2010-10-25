<?php

function smarty_function_grid($params){


    $classObj = $params['classObj'];
    
    $module = $classObj->getName();

    $data = $classObj->getValue();

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
//$data = $params['data'];

$colNames = array();
$colModel = array();

$fields = $classObj->getGridFields();

if ($fields){
    foreach ($fields as $i=>$name){
        $colNames[] = Locale::get($name, $module);
        $sorttype = 'text';
        $value = '';
        if (isset($data[0])){
            $value = $data[0][$name];
        }
        if ((int)($value) > 0) $sorttype = 'int';
        if (preg_match("/\d{2,4}[\.\-]+\d{2}[\.\-]+\d{2,4}/", $value)) $sorttype = 'date';
        $colModel[] = array(
            'name'  => $name,
            'index' => $name,
            'sorttype' => $sorttype
            );
    }
}
$colNamesJS = json_encode($colNames);
$colModelJS = json_encode($colModel);

$html = "<table id='{$module}Grid' class='scroll'>";
foreach ($data as $i=>$row){
    $html .= '<tr id="'.$row['ID'].'" class="ui-widget-content jqgrow ui-row-ltr" role="row">';
    foreach ($row as $name=>$cell){
        if (!in_array($name, $fields)) continue;
        $html .= '<td>';
        $html .= $cell;
        $html .= '&nbsp;</td>';
    }
    $html .= '</tr>';
}
$html .= '</table>';

$html .=<<<HTML

<div id="{$module}GridPager"></div>

<script>
jQuery(document).ready(function(){
        var lastSel;
        $("#{$module}Grid").jqGrid({
            datatype: 'html',
            colNames: {$colNamesJS},
            colModel : {$colModelJS},
            pager: '#{$module}GridPager',
            rowNum:5,
            rowList:[2,5,10,15,30,50],
            viewrecords: true,
            imgpath: 'themes/basic/images',
            caption: '{$module}',
            height: 'auto',
            ondblClickRow: function(id) {
                if (id && id != lastSel) {
                    $("#{$module}Grid").restoreRow(lastSel);
                    $("#{$module}Grid").editRow(id, true);
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