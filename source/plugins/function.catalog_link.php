<?php
function smarty_function_catalog_link($params, &$smarty)
{
	$db = &$smarty->get_registered_object("db");


	if ($params['category']){
		$category_id = $params['category'];
	}
	if ($params['item']){
		$item_id = $params['item'];
	}
	
	if (MOD_REWRITE){
		
		if ($item_id){
			$sql = $db->prepare("SELECT CategoryID, LinkAlias FROM ".CAT_PREFIX."item WHERE ID='".$item_id."'");
			$res = $db->Execute($sql);
			if ($res && $res->RecordCount() > 0){
				$category_id = $res->fields['CategoryID'];
			}
		} 
		if ($category_id){
			$category_path = getPath($category_id);
			$category_path = array_reverse($category_path);
		} 
		
		$link_arr = array(CATALOG_ROOT_URL);
		$link_arr = array_merge($link_arr, $category_path);
		array_push($link_arr, $res->fields['LinkAlias']);
		
		$link = implode("/", $link_arr);
		$link = str_replace('//','/', $link);
		return $link;
	} else {
		if ($category_id){
			return '/index.php?'.MODULE.'=catalog&mode=category&id='.$category_id;
		}
		if ($item_id){
			return '/index.php?'.MODULE.'=catalog&mode=item&id='.$item_id;
		}
	}

}


function getPath($parentID=0, $arr=array()){
	global $db;
	$sql = $db->prepare("SELECT ParentID, LinkAlias FROM ".CAT_PREFIX."category WHERE ID='".$parentID."'");
	$res = $db->Execute($sql);
	if ($res && $res->RecordCount() > 0){
		array_push($arr, $res->fields['LinkAlias']);
		$arr = getPath($res->fields['ParentID'], $arr);
	}
	return $arr;
}
?>