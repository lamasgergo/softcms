<?php
class Log {
    private static $instance;

    private static $log = array();

    private function __construct() {
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new Log();
        }
        return self::$instance;
    }

    public function add($msg=''){
        if (!empty($msg)){
            self::$log[] = $msg;
        }
    }

    public function get($splitter='<br>'){
        if (count(self::$log) > 0){
            return implode($splitter, self::$log);
        }
    }
}
?>