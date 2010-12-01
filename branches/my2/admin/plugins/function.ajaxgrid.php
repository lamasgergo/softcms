<?php

function smarty_function_ajaxgrid($params){


    $classObj = $params['classObj'];
    
    $module = $classObj->getName();

//    $data = $classObj->getValue();



$colNames = array();
$colModel = array();

$fields = $classObj->getGridFields();
if ($fields){
    foreach ($fields as $i=>$name){
        $colNames[] = Locale::get($name, $module);
        $sorttype = 'text';
//        $value = '';
//        if (isset($data[0])){
//            $value = $data[0][$name];
//        }
//        if ((int)($value) > 0) $sorttype = 'int';
//        if (preg_match("/\d{2,4}[\.\-]+\d{2}[\.\-]+\d{2,4}/", $value)) $sorttype = 'date';
        $colModel[] = array(
            'name'  => $name,
            'index' => $name,
            'sorttype' => $sorttype
            );
    }
}
$colNamesJS = json_encode($colNames);
$colModelJS = json_encode($colModel);


$html =<<<HTML
<table id='{$module}Grid' class='scroll'></table>
<div id="{$module}GridPager"></div>

<script>
jQuery(document).ready(function(){
        var lastSel;
        $("#{$module}Grid").jqGrid({
            url: '/admin/ajax.php?class={$module}&mod={$classObj->moduleName}&method=jqGridData',
            datatype: 'json',
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