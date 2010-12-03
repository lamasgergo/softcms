<?php
/*
 * params @file
 * params @show
 */
function smarty_function_image_info($params){
    $file = $params['file'];
    if (!file_exists($file) && !file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$file)) return false;
    $show = $params['show'];

    if ($show=='name'){
        $name = preg_replace("/^.*\/(.+)\.\w+?$/ui", "\\1", $file);
        if (empty($name)) $name = $file;
        return $name;
    }
    if ($show=='resolution'){
        if (strpos('http://', $file)){
            $image = $file;
        } else $image = $_SERVER['DOCUMENT_ROOT'].'/'.$file;
        if (file_exists($image)){
            list($width, $height) = getimagesize($image);
            if ($width && $height) return $width.'x'.$height;
        }
        return false;
    }
}

?>