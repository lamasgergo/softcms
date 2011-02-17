<?php
namespace Utils;

class Translit {

    private static $char_convert = array(
        'а' => 'a',  'к' => 'k', 'х' => 'h',
        'б' => 'b',  'л' => 'l', 'ц' => 'ts',
        'в' => 'v',  'м' => 'm', 'ч' => 'ch',
        'г' => 'g',  'н' => 'n', 'ш' => 'sh',
        'д' => 'd',  'о' => 'o', 'щ' => 'sch',
        'е' => 'e',  'п' => 'p', 'ь' => '',
        'ё' => 'yo', 'р' => 'r', 'ъ' => '',
        'ж' => 'zh', 'с' => 's', 'ы' => 'y',
        'з' => 'z',  'т' => 't', 'э' => 'e',
        'и' => 'i',  'у' => 'u', 'ю' => 'yu',
        'й' => 'j',  'ф' => 'f', 'я' => 'ya',

        'А' => 'A',  'К' => 'K', 'Х' => 'H',
        'Б' => 'B',  'Л' => 'L', 'Ц' => 'Ts',
        'В' => 'V',  'М' => 'M', 'Ч' => 'Ch',
        'Г' => 'G',  'Н' => 'N', 'Ш' => 'Sh',
        'Д' => 'D',  'О' => 'O', 'Щ' => 'Sch',
        'Е' => 'E',  'П' => 'P', 'Ь' => '',
        'Ё' => 'Yo', 'Р' => 'R', 'Ъ' => '',
        'Ж' => 'Zh', 'С' => 'S', 'Ы' => 'Y',
        'З' => 'Z',  'Т' => 'T', 'Э' => 'E',
        'И' => 'I',  'У' => 'U', 'Ю' => 'Yu',
        'Й' => 'J',  'Ф' => 'F', 'Я' => 'Ya',
        ' ' => '-');
    private static $apostrofs = array(

        'ь' => "'",
        'ъ' => "'",
        'Ь' => "'",
        'Ъ' => "'"

        );


    public static function encode($string,$useApostrof=false) {
       if($useApostrof) $encodeArray=array_merge(self::$char_convert,self::$apostrofs);
       else   $encodeArray=self::$char_convert;
       $string=strtr($string,$encodeArray);
       return $string;
    }

}

?>
