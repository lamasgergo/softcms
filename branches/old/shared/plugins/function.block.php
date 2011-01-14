<?
function smarty_function_block($params, &$smarty){
	global $lang;
	
	$db = &$smarty->get_registered_object ("db");
	if (! isset ($params ['var']) || empty ($params ['var'])) {
		$params ['var'] = '';
	}
	if (isset ($params ['params']) && ! empty ($params ['params'])) {
		$params ['params'] = preg_replace("/\s+/","",$params ['params']);
		$_params = explode(",", $params ['params']);
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
	if (is_file (MODULES_DIR . "/" . $params ['name'] . "/" . $params ['name'] . ".php")) {
		include (MODULES_DIR . "/" . $params ['name'] . "/" . $params ['name'] . ".php");
		echo $output;
	} else {
		echo $lang ["module_not_exists"] . ": " . $params ["name"];
	}
	
	unset ($db);
}
?>