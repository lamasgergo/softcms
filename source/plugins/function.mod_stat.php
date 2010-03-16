<?
function smarty_function_mod_stat($params, &$smarty)
{
	$db = &$smarty->get_registered_object("db");
	
	$title = $params["title"];	
	$link = $params["link"];	
	$description = $params["description"];	

	
	if (!empty($title) && !empty($link)){
		
		$link = preg_replace("/[\&|\?]+page\=\d+/",'',$link);
		
		$sql = $db->prepare("INSERT INTO ".DB_PREFIX."stat_pages(Title,Link,Description,Visited) VALUES ('".$title."','".$link."','".$description."',NOW())");
		$db->Execute($sql);
	}
	
	unset($db);
}

?>