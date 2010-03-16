<?
function smarty_function_mod_admin_common_link($params, &$smarty)
{
        $value = $params['value'];
        // здесь выполнить интеллектуальный перевод строки $content
        return "http://".HOST."/admin/common/".$value.".php";
}

?>