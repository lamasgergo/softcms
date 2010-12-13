<?php
function smarty_function_html_checkbox($params){
    $attr = array();

    if (isset($params["selected"]) && !empty($params['selected'])){
        if (isset($params["value"]) && !empty($params['value'])){
            if ($params["value"]==$params["selected"]){
                $params["checked"] = 'checked';
            }
        }
    }

    foreach ($params as $name=>$value){
        if (isset($params[$name]) && !empty($params[$name])){
            $name = strtolower($name);
            if ($value!=''){
                $value = htmlspecialchars($value);
                $attr[] = "{$name}='{$value}'";
            }
        }
    }
    if (!empty($attr)){
        $attr = implode(" ", $attr);
        return "<input type='checkbox' {$attr} onChange='javascript:{if(this.checked){this.value=\"{$params['value']}\"}else{this.value=\"{$params['default']}\"}}'/>";
    }
}

?>