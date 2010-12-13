<?php

function smarty_function_ajaxgrid($params){


    $classObj = $params['classObj'];
    
    $component = $classObj->getName();
    $module = $classObj->getType();

//    $data = $classObj->getValue();



$colNames = array();
$colModel = array();

$fields = $classObj->getGridFields();
if ($fields){
    foreach ($fields as $i=>$name){
        $colNames[] = Locale::get($name, $component);
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


$changeTabTitle = Locale::get("Change", $component);

$html =<<<HTML
<table id='{$component}Grid' class='scroll'></table>
<div id="{$component}GridPager"></div>

<script>
jQuery(document).ready(function(){
        var lastSel;
        $("#{$component}Grid").jqGrid({
            url: '/admin/ajax.php?class={$component}&mod={$classObj->moduleName}&method=jqGridData',
            datatype: 'json',
            colNames: {$colNamesJS},
            colModel : {$colModelJS},
            pager: '#{$component}GridPager',
            rowNum:5,
            rowList:[2,5,10,15,30,50],
            viewrecords: true,
            imgpath: 'themes/basic/images',
            caption: '{$component}',
            height: 'auto',
            width: $('#backend .ui-tabs-panel').width(),
            sortorder: 'DESC',
            ondblClickRow: function(id) {
                    var title = '$changeTabTitle';
			        addTab(title, 'change', '{$module}', '{$component}', id);
                    lastSel = id;
            },
        });
//        jQuery("#{$component}Grid").jqGrid('navGrid','#{$component}GridPager',
//            {}, //options
//            {height:280,reloadAfterSubmit:false}, // edit options
//            {height:280,reloadAfterSubmit:false}, // add options
//            {reloadAfterSubmit:false}, // del options
//            {} // search options
//        );
    });
</script>
HTML;

    return $html;
}
?>