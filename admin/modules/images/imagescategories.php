<?php
require_once (dirname(__FILE__)."/../../modules/article/categories.php");

class ImagesCategories extends Categories{
    protected $type = 'images';

	function __construct(){
        parent::__construct();
        $this->templatePath = dirname(__FILE__).'/templates/categories/';
	}


	function getName(){
		return strtolower(__CLASS__);
	}

	//set common template vars
	function setTemplateVars() {
        $this->smarty->assign("module", $this->moduleName);
        $this->smarty->assign("component", $this->getName());
    }
}
?>