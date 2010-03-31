<?php

class ObjectRegistry {

    private $objects = array();

    public static function &getInstance() {
        static $registry = false;
        if (!$registry) {
            $registry = new ObjectRegistry();
        }
        return $registry;
    }

    function get($name){
        return $this->objects[$name];
    }

    function set($name, $object){
        return $this->objects[$name] = $object;
    }

}
