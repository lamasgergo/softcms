<?php
$url = preg_replace("/contacts\//","",$_SERVER['REQUEST_URI']);
$file = $_SERVER['DOCUMENT_ROOT'].'/m&mcontacts/'.$url.'/index.php';
if (file_exists($file)){
	include_once($file);
}
?>