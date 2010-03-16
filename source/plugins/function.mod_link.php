<?
function smarty_function_mod_link($params, &$smarty)
{
        
        $value = $params['value'];
        $name = $params['name'];
        $img = $params['img'];
        $width = $params['width'];
        $height = $params["height"];
        $alt = $params["alt"];
        $class = $params["class"];
        if (isset($img) && !empty($img)){
          return "<a href='http://".HOST."/index.php?mod=".$value."' class='".$class."'><img src='".$img."' width='".$width."' height='".$height."' border='0' alt='".$alt."'></a>";
        }
        else {
          return "<a href='http://".HOST."/index.php?mod=".$value."' class='".$class."'>".$name."</a>";
        }
}

?>