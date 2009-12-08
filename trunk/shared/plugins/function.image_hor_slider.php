<?
function smarty_function_image_hor_slider($params, &$smarty)
{
  global $lang;
  $db = &$smarty->get_registered_object("db");
  $group = $params['ImageGroupID'];
  $width = $params['width'];
  $href = $params['href'];
  $show_link = intval($params['show_link']);
  
	$dir = $params['dir'];
	$dirURL = $params['dirURL'];
	
	if (empty($dir)){
		$dir = uploadDirectory;
	}
	
	if (empty($dirURL)){
		$dirURL = uploadDirectoryURL;
	}
  if ($show_link==1){
      $show_link=true;
  } else {
      $show_link = false;
  }
  $count = $params['count'];
  if (empty($count)){
    $count  = 2;
  } else {
    $count = $count-1;  
  }
  $rows = $params['rows'];
  if (empty($rows)){
    $rows  = 2;
  } else {
    $rows = $rows;  
  }

  $ret = "";
  if (isset($group) && !empty($group)){
    $sql2 = $db->prepare("SELECT ID FROM bs_images_group WHERE ID='".$group."'");
    $res2 = $db->execute($sql2);
    if ($res2 && $res2->RecordCount() > 0){
      $sql = $db->prepare("SELECT * FROM ".DB_PREFIX."images WHERE GroupID='".$group."' ORDER BY ID ASC LIMIT 0,1");
    }
  }
  if (!empty($sql)){
    $res = $db->Execute($sql);
    if ($res && $res->RecordCount() > 0){
      $res = $db->Execute($sql);
      if ($res && $res->RecordCount() > 0){
        $file_resize = $res->fields["Image"];
        $name = $res->fields["Name"];
      } else {
        $file_resize = "common/no_image.gif";
        $name="No photo";
      }
    } else {
      $file_resize = "common/no_image.gif";
      $name="No photo";
    }
    if (file_exists($dir.$file_resize)){
      $ret .= '<div id="dhtmlgoodies_slideshow">
          		<div id="previewPane">';
      $ret .= "<img src='".$dirURL.$file_resize."' border='0' title='".$name."' alt='".$name."'";
      $ret .= get_ratio($dir.$file_resize,'380','380');
      $ret .= ">";
      $ret .='<span id="waitMessage">Loading image. Please wait</span>	
				<div id="largeImageCaption"></div>';
      $ret .='</div>';  

    }
  }
  
  // make a list of photos
  if (isset($group) && !empty($group)){
    $sql2 = $db->prepare("SELECT ID FROM bs_images_group WHERE ID='".$group."'");
    $res2 = $db->execute($sql2);
    if ($res2 && $res2->RecordCount() > 0){
      $sql = $db->prepare("SELECT * FROM ".DB_PREFIX."images WHERE GroupID='".$group."' ORDER BY ID ASC");
    }
  }
  if (!empty($sql)){
    $res = $db->Execute($sql);
    if ($res && $res->RecordCount() > 0){
      $ret .= '<div id="galleryContainer">
				<div id="arrow_left"><img src="/source/templates/design/default/images/slider/arrow_left.gif"></div>
				<div id="arrow_right"><img src="/source/templates/design/default/images/slider/arrow_right.gif"></div>
				<div id="theImages">';
      while (!$res->EOF){
        if ($res && $res->RecordCount() > 0){
          $file_resize = $res->fields["ImageResize"];
          $name = $res->fields["Name"];
        } else {
          $file_resize = "common/no_image.gif";
          $name="No photo";
        }
        if (file_exists($dir.$file_resize)){
          $ret .= '<a href="#" onclick="showPreview(\'';
          $ret .= $dirURL.$res->fields["Image"];
          $ret .= '\',\'1\');return false">';
          $ret .= "<img src='".$dirURL.$file_resize."' '.$width_str.' border='0' title='".$name."' alt='".$name."' ";
          $ret .= get_ratio($dir.$file_resize,$width,$height);
          $ret .= ">";
          $ret .= '</a>';
        }
        $res->MoveNext();
      }
      $ret .= '<div id="slideEnd"></div>
		</div>
	</div>
</div>
         ';
    }
  }


unset($db);
return $ret;
}
?>
