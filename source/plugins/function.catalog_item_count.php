<?
function smarty_function_catalog_item_count($params, &$smarty)
{
	$db = &$smarty->get_registered_object("db");
	
	$id = $params["id"];	
		
	if (!empty($id)){
		
		$sql = $db->prepare("UPDATE ".CAT_PREFIX."item SET ViewCount=ViewCount+1 WHERE ID='".$id."'");
		$db->Execute($sql);
	}
	
	unset($db);
}

?>