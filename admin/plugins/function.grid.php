<?php

function smarty_function_grid(){

$html =<<<HTML

<table id="list" class="scroll"></table>
<div id="pager" class="scroll" style="text-align:center;"></div>

<script>
jQuery(document).ready(function(){
        var lastSel;
        jQuery("#list").jqGrid({
            url:'/admin/ajax.php?mod=base&class=basecategories&method=getValue',
            datatype: 'json',
            mtype: 'POST',
            colNames:['#', 'test1', 'test2', 'test3'],
            colModel :[
                {name:'id', index:'id', width:30}
                ,{name:'surname', index:'surname', width:80, align:'right', editable:true, edittype:"text"}
                ,{name:'fname', index:'fname', width:90, editable:true, edittype:"text"}
                ,{name:'lname', index:'lname', width:80, align:'right', editable:true, edittype:"text"}
                ],
            pager: jQuery('#pager'),
            rowNum:5,
            rowList:[5,10,30],
            sortname: 'id',
            sortorder: "asc",
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
            editurl: 'saverow.php'
        });
    });
</script>
HTML;


    return $html;
}
?>