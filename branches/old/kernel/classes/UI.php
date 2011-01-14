<?php


class UI extends base{
    var $block_vars;

    var $dynamic;

    var $vars;

    var $data;

    function UI(){
        global $dynamic, $block_vars;

        parent::base();

        $this->dynamic = $dynamic;
        $this->block_vars = $block_vars;
    }

    function setVars($vars=array()){
        $this->vars = $vars;

        if (isset($vars['id']) && !empty($vars['id'])) $this->id = $vars['id'];
        if (isset($vars['type']) && !empty($vars['type'])) $this->id = $vars['type'];
    }

    function prepareOutput(){
        return array();
    }

    function output($tpl=''){
        $this->prepareOutput();
        $this->smarty->assign("data", $this->data);
        
        if (isset($tpl) && !empty($tpl)) $this->tpl = strtolower ( $tpl ).'.tpl';
        if (!isset($this->tpl) || empty($this->tpl)) $this->tpl = 'index.tpl';
        return $this->smarty->fetch ( strtolower ( $this->moduleName ) .'/'.$this->tpl, null, $this->language );
    }
}
