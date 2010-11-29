<?php

class Translit {

    private static $singleRus = array('а', 'б', 'в', 'г', 'д', 'е', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ъ');
    private static $singleLat = array('a', 'b', 'v', 'g', 'd', 'e', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', '-');

    private static $singleRusU = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ъ');
    private static $singleLatU = array('A', 'B', 'V', 'G', 'D', 'E', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', '-');

    private static $pairRus = array('ё', 'ж', 'ц', 'ч', 'ш', 'щ', 'ю', 'я', 'э', 'ь', 'ы');
    private static $pairLat = array('yo', 'zh', 'tc', 'ch', 'sh', 'sh', 'yu', 'ya', 'ee', '__', 'ii');

    private static $pairRusU = array('Ё', 'Ж', 'Ц', 'Ч', 'Ш', 'Щ', 'Ю', 'Я', 'Э', 'Ь', 'Ы');
    private static $pairLatU = array('YO', 'ZH', 'TC', 'CH', 'SH', 'SH', 'YU', 'YA', 'EE', '__', 'II');

    public static function encode($string) {
        $string = str_replace(self::$pairRus, self::$pairLat, $string);
        $string = str_replace(self::$singleRus, self::$singleLat, $string);
        $string = str_replace(self::$pairRusU, self::$pairLatU, $string);
        $string = str_replace(self::$singleRusU, self::$singleLatU, $string);
        return $string;
    }

    public static function decode($string) {
        $string = str_replace(self::$pairLat, self::$pairRus, $string);
        $string = str_replace(self::$singleLat, self::$singleRus, $string);
        $string = str_replace(self::$pairLatU, self::$pairRusU, $string);
        $string = str_replace(self::$singleLatU, self::$singleRusU, $string);
        return $string;
    }

    public static function makeUrl($string){
        $string = self::encode($string);
        $string = preg_replace('/\s/uis', '-', $string);
        $string = preg_replace('/[^\w\d\/\_-]/uis', '', $string);
        $string = preg_replace('/\/+/uis', '/', $string);
        $string = strtolower($string);
        return $string;
    }
}
