<?php

class Locale {

    private $locale;

    function __construct(){

    }

    function get($var){
        if (isset($this->locale[$var])) return $this->locale[$var];
        return $var;
    }
}
