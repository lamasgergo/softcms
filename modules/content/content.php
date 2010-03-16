<?php

include_once(MODULES_DIR."/content/content.class.php");
include_once(MODULES_DIR."/comments/comments.class.php");

$content = new Content($block_vars,$dynamic);
$output = $content->show();


$regexp = "/\{(\w+)([^\}]+)\}/";
if (preg_match($regexp,$output, $match)){
	$plugin_file = MODULES_DIR."/content/content.php";
	if ($match[1] && file_exists($plugin_file)){
		if ($match[2]){
			preg_match("/params\s*\=\s*[\|'\"]+([^\|'\"]+)[\|'\"]+/",$match[2], $params);
			$_params = explode(",", $params[1]);
			$block_vars = array();
			foreach($_params as $param) {
				list($name, $value) = explode("=", $param);
				$name = trim ($name);
				$value = trim ($value);
				if (! empty ($name) && ! empty ($value)) {
					$block_vars[$name] = $value;
				}
			}
		}
		
		$content = new Content($block_vars,false);
		$plugin_output = $content->show();
		
	} else $plugin_output = '';
	
	$output = preg_replace($regexp, $plugin_output , $output);
}
?>