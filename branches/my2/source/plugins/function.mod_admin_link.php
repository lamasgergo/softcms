<?
function smarty_function_mod_admin_link($params, &$smarty)
{
        $value = $params['value'];
        return "http://".HOST."/admin/index.php?mod=".$value;
}

?>