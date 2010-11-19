<?php

class article extends Base{

    public $type = 'article';

    function __construct(){
        parent::__construct();
        echo $this->templatePath;
    }

}
?>