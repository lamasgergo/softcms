<?php

class Page extends base{

	var $url = '/';
    var $tpl = '';
    var $designDir = '/design';
    var $blocks = array();
    var $blocksInfo = array();
    var $_paramsSeparator = ',';
    var $_dynamicBlockName = 'BODY';
    var $_moduleVarName = 'mod'; 



	function Page($module=null){

        parent::base();

        $this->getURL();
        $this->getPageData();
	}

    function getURL(){
        $this->url = $_SERVER['REQUEST_URI'];
        if (isset($this->url) && !empty($this->url)){
            $this->url = '/';
        }
    }

    function getPageData(){
        $sql = $this->db->prepare("SELECT ID, tpl FROM ".DB_PREFIX."pages WHERE url='".$this->url."' AND lang='".$this->language."'");
        $res = $this->db->execute($sql);
        if ($res && $res->RecordCount() > 0){
            $this->tpl = $res->fields['tpl'];
            $this->setupTemplateVars();
            $this->setupBlocks($res->fields['ID']);
        }
    }

    function setupTemplateVars(){
         $this->smarty->assign("js", $this->designDir.'/js');
         $this->smarty->assign("css", $this->designDir.'/css');
         $this->smarty->assign("images", $this->designDir.'/images');
    }

    function setupBlocks($blockID){
        $blockID = intval($blockID);
        if ($blockID<=0) return false;
        $blocksInfo = array();
        $sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."page_blocks WHERE PageID='".$blockID."' ORDER BY `Order`");
        $res = $this->db->execute($sql);
        if ($res && $res->RecordCount() > 0){
            $this->blocksInfo = $res->getArray();
            $this->parseBlocksInfo();
        }
    }

    function parseBlocksInfo(){
        if (!$this->blocksInfo || !is_array($this->blocksInfo) || count($this->blocksInfo)==0) return false;

        $templateVars = $this->getTemplateVars();

        foreach ($this->blocksInfo as $item){
            if (in_array($item['Name'], $templateVars)){
                $i = count($this->blocks[$item['Name']]);
                $this->blocks[$item['Name']][$i]['module'] = $item['Module'];
                $this->blocks[$item['Name']][$i]['params'] = $this->parseBlockParams($item['Params']);
            }
        }
       
    }

    function parseBlockParams($params=''){
        $parsed = array();
        if (empty($params) || strpos($params, '=')===false) return $parsed;

        $vars = explode($this->_paramsSeparator, $params);
        if (count($vars) > 1){
            foreach ($vars as $pairs){
                list($var, $value) = explode("=", $pairs);
                $parsed[trim($var)] = trim($value);
            }
        }
        return $parsed;
    }

    function getTemplate(){
        return $_SERVER['DOCUMENT_ROOT'].'/'.$this->designDir.'/'.$this->tpl;
    }

    function getTemplateVars(){
        if (!$this->tpl || !file_exists($this->getTemplate())) die('Template not defined');
        $template = file_get_contents($this->getTemplate());
        $blocks = array();
        preg_match_all("/\{[$]([A-Z\d\_\-]+)\}/s", $template, $vars);
        if (count($vars[1]) > 0){
			for ($i=0;$i<count($vars[1]);$i++) {
				if ($vars[1][$i]){
					array_push($blocks,$vars[1][$i]);
				}
			}
		}
		return $blocks;
    }

    function getModule($moduleName){
        return $_SERVER['DOCUMENT_ROOT'].'/modules/'.$moduleName.'/'.$moduleName.'.php';
    }

    function includeModule($moduleName){
        if (file_exists($this->getModule($moduleName))){
            include_once($this->getModule($moduleName));
        }
    }

    function isDynamicBlock($name){
        return ($name==$this->_dynamicBlockName);
    }

    function getContent($name, $vars=array()){
        $result = '';
        $this->includeModule($name);
        if (class_exists($name)){
            $class = new $name();
            if (method_exists($class, 'output')){
                $result = $class->output();
            }
        }
        if (empty($result) && !empty($output)){
            $result = $output;
            unset($output);
        }
        return $result;
    }

    function fillStatic($blocks){
        $result = '';
        foreach ($blocks as $block){
            $result .= $this->getContent($block['module'], $block['params']);
        }
        return $result;
    }

    function fillDynamic($blocks){
        $content = '';
        $module = $_GET[$this->_moduleVarName];
        if (isset($module) && !empty($module)){
            $content = $this->getContent($module, $_GET);
        } else {
              $content = $this->fillStatic($blocks);
        }
        return $content;
    }

    function display(){
        foreach ($this->blocks as $blockName=>$blocks){
            if ($this->isDynamicBlock($blockName)){
                $result = $this->fillDynamic($blocks);
            } else {
                $result = $this->fillStatic($blocks);
            }

            $this->smarty->assign($blockName, $result);
        }

        $this->smarty->display($this->tpl,null,$this->language); 
    }
}
?>
