<?
function smarty_function_npa_image_slider($params, &$smarty)
{
  global $lang;
  $value = $params['value'];
  $width = $params['width'];
  $href = $params['href'];
  $show_link = intval($params['show_link']);
  
  $origwidth = '294';

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

	$images = explode("\r\n", $value);
	
	foreach ($images as $i=>$image){
		$images[$i] = preg_replace('/width\=\d+/', 'width='.$origwidth, $image);
	}
	
	foreach ($images as $i=>$image){
		$images_small[$i] = preg_replace('/width\=\d+/', 'width='.$width, $image);
	}
  
  $ret = "";
  if (!empty($value)){
    
	
	
      $ret .= '<div id="DHTMLgoodies_largeImage">
          <table>
            <tr>
              <td>';
      $ret .= "<img src='".$images[0]."' border='0' />";
      $ret .='</td>
            </tr>';
      $ret .='</table>
        </div>';  

  }
  
  // make a list of photos
  if (!empty($value)){
      $i=0;
      $j=0;
      $ret .= '<div id="DHTMLgoodies_panel_one" style="width: '.(($width*($rows))+(5*$rows)).'px;">
            <div id="DHTMLgoodies_thumbs" style="height:'.(($width/(800/600))*($count+1)).'px; padding-bottom: 25px;">
              <div id="DHTMLgoodies_thumbs_inner">';
      foreach ($images_small as $cc=>$image){
        $j++;
        if ($i==0){
          $ret .= '<div class="strip_of_thumbnails" style="width:'.$width.'px;">';
        }
        if ($j==1){
          $firstid = 'id="firstThumbnailLink"'; 
        } else {
          $firstid = '';
        }
        
        if (!empty($width)){
          $width_str = 'width="'.$width.'"';  
        }
          $ret .= '<div><a '.$firstid.'href="#" onclick="showPreview(\'';
          $ret .= $images[$cc];
          $ret .= '\',this);return false;">';
          $ret .= "<img src='".$image."' '.$width_str.' border='0' />";
          $ret .= '</a></div>';
        if ($i==$count || $j == count($images)){
          $i=0;
          $ret .= '</div>';
        } else {
          $i++; 
        }
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
