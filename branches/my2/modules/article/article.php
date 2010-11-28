<?php
require_once dirname(__FILE__).'/../../kernel/Base.php';

class article extends Base{

    public $type = 'article';

    function __construct(){
        parent::__construct();
    }

    function getConditions(){
        $where = parent::getConditions();
        $where[] = "`Published`='1'";
        return $where;
    }
}
?>