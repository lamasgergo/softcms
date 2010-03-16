<?
function smarty_function_show_image($params, &$smarty)
{
	$db = &$smarty->get_registered_object("db");
	$group = $params['group'];
	$width = $params['width'];
	$height = $params['height'];
	$orig = $params['orig'];
	$origLink = $params['origLink'];
	$url = $params['url'];
	$count = $params['count'] ? $params['count'] : 1;
	$class = $params['class'];
	$random = $params['random'];
	$delimiter = $params['delimiter'];
	
	$dir = $params['dir'];
	$dirURL = $params['dirURL'];
	
	if (empty($dir)){
		$dir = uploadDirectory;
	}
	
	if (empty($dirURL)){
		$dirURL = uploadDirectoryURL;
	}
	
	
	
	$ret = "";
	if (isset($group) && !empty($group)){
		$sql2 = $db->prepare("SELECT ID FROM bs_images_group WHERE ID='".$group."'");
		$res2 = $db->execute($sql2);
		if ($res2 && $res2->RecordCount() > 0){
			if ($random==1){
				$sql = $db->prepare("SELECT * FROM ".DB_PREFIX."images WHERE GroupID='".$group."' ORDER BY RAND() LIMIT ".$count);
			} else {
				$sql = $db->prepare("SELECT * FROM ".DB_PREFIX."images WHERE GroupID='".$group."' ORDER BY ID ASC LIMIT ".$count);	
			}
		}
	}
	
	if (!empty($sql)){
		$res = $db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			while (!$res->EOF){
				if ($orig=="true"){
					$file_resize = $res->fields["Image"];
				} else {
					$file_resize = $res->fields["ImageResize"];
				}
				$name = $res->fields["Name"];
	

				if (file_exists($dir.$file_resize)){
					$closeATag = false;
					if (($origLink=="true" && $origLink==true) || !empty($url)){
						if ($origLink==true){
							$ret .= "<a href='".$dirURL.$res->fields["Image"]."' target='_blank'>";
							$closeATag = true;
						}
						if (!empty($url)){
							$ret .= "<a href='".LinkHelper::getStaticLink($url)."'>";
							$closeATag = true;
						}
					}
					if (!empty($class)){
						$class = "class='".$class."'";
					}
					
					$ret .= "<img src='".$dirURL.$file_resize."' id='".$dirURL.$res->fields["Image"]."' border='0' title='".$name."' alt='".$name."' ".$class;
					$ret .= get_ratio($dir.$file_resize,$width,$height);
					$ret .= ">";
					if ($closeATag==true){
						$ret .= "</a>";
					}
					$ret .= $delimiter;
				}
				$res->MoveNext();
			}
		}
	}

	unset($db);
	return $ret;
}



?>