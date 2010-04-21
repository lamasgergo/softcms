<?php
header('Content-type: text/html; charset=utf-8');
ini_set('display_errors', 1);
include_once $_SERVER['DOCUMENT_ROOT'].'/kernel/Translit.php';

$string = "йцукенгшщзхъ  фывапролджэ  ячсмитьбю  ЙЦУКЕНГШЩЗХЪ  ФЫВАПРОЛДЖЭ  ЯЧСМИТЬБЮ";

echo $string."<br>";

$encoded = Translit::encode($string);
echo $encoded."<br>";
echo Translit::decode($encoded)."<br>";
?>