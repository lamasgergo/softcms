<?php

class TreeLayout {
    var $areas;
    var $AREA_LEFT = 'LEFT';
    var $categories;
    var $content;

    var $smarty;

    function TreeLayout(){
        global $smarty;
        $this->smarty = &$smarty;
    }

    function addCategories($obj){
        $this->categories = $obj;
    }

    function addContent($obj){
        $this->content = $obj;
    }

    function show(){
        $this->smarty->assign("LEFT", '123');
        $this->smarty->assign("BODY", $this->content->showGrid());
    }
}
