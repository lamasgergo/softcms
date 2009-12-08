<?
function smarty_function_image_slider($params, &$smarty)
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
      $ret .= '<div id="DHTMLgoodies_largeImage">
          <table>
            <tr>
              <td>';
      if ($show_link!=false){
          $ret .= '<a class="largeImage" href="index.php?'.MODULE.'=auto_images&gid='.$group.'" target="_blank">';
      }
      $ret .= "<img src='".$dirURL.$file_resize."' border='0' title='".$name."' alt='".$name."'";
      $ret .= get_ratio($dir.$file_resize,$width,$height);
      $ret .= ">";
      if (($orig=="true" || !empty($href)) && $href!="false"){
        $ret .= "</a>";
      }
      $ret .='</td>
            </tr>';
      if ($show_link!=false){
        $ret .='<tr>
              <td><a class="largeImage" href="index.php?'.MODULE.'=auto_images&gid='.$group.'" target="_blank">'.$lang["auto_shop_large_image"].'</a></td>
            </tr>';
      }
      $ret .='</table>
        </div>';  

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
      $i=0;
      $j=0;
      $ret .= '<div id="DHTMLgoodies_panel_one" style="width: '.(($width*($rows))+(5*$rows)).'px;">
            <div id="DHTMLgoodies_thumbs" style="height:'.(($width/(800/600))*($count+1)).'px; padding-bottom: 25px;">
              <div id="DHTMLgoodies_thumbs_inner">';
      while (!$res->EOF){
        $j++;
        if ($i==0){
          $ret .= '<div class="strip_of_thumbnails" style="width:'.$width.'px;">';
        }
        if ($j==1){
          $firstid = 'id="firstThumbnailLink"'; 
        } else {
          $firstid = '';
        }
        
        if ($res && $res->RecordCount() > 0){
          $file_resize = $res->fields["ImageResize"];
          $name = $res->fields["Name"];
        } else {
          $file_resize = "common/no_image.gif";
          $name="No photo";
        }
        if (!empty($width)){
          $width_str = 'width="'.$width.'"';  
        }
        if (file_exists($dir.$file_resize)){
          $ret .= '<div><a '.$firstid.'href="#" onclick="showPreview(\'';
          $ret .= $dirURL.$res->fields["Image"];
          $ret .= '\',this);return false;">';
          $ret .= "<img src='".$dirURL.$file_resize."' '.$width_str.' border='0' title='".$name."' alt='".$name."' ".$class;
          $ret .= get_ratio($dir.$file_resize,$width,$height);
          $ret .= ">";
          $ret .= '</a></div>';
        }
        if ($i==$count || $j == $res->RecordCount()){
          $i=0;
          $ret .= '</div>';
        } else {
          $i++; 
        }
        $res->MoveNext();
      }
      $ret .= '<!-- End where you put your small thumbnails -->
            </div>
          </div>
         <!-- Arrow images - You can change the "src", but not the "id" -->
           <div id="DHTMLgoodies_arrows">
             <img id="DHTMLgoodies_leftArrow" class="leftArrow" src="/source/images/gallery/arrow_left.gif"></a>
             <img id="DHTMLgoodies_rightArrow" class="rightArrow" src="/source/images/gallery/arrow_right.gif"></a>
           </div>
         </div>
         ';
    }
  }


$columns = floor($j/($count+1));
if ($columns==1) $columns=0;

$ret .= '
<script type="text/javascript">
 columnsOfThumbnails = '.$columns.';
 initGalleryScript();  // Initialize script
</script>
';

unset($db);
return $ret;
}
?>
