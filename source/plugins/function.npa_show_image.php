<?
function smarty_function_npa_show_image($params, &$smarty)
{
	$value = $params['value'];
	$href = $params['href'];
	
	$images = explode("\r\n", $value);
	
	foreach ($images as $i=>$image){
		$images[$i] = preg_replace('/width\=\d+/', 'width='.image_resize_x, $image);
	}
	
	#print_r($images);
	$ret = '';
	if (!empty($href)){
		$ret .= "<a href='http://".HOST."/index.php?mod=".$href."'>";
	}
	
	$ret .= "<img src='".$images[0]."' border='0' width='".image_resize_x."' />";
	
	if (!empty($href)){
		$ret .= "</a>";
	}

	return $ret;
}



?>