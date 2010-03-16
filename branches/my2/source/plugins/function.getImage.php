<?
function smarty_function_getImage($params, &$smarty)
{
    $db = &$smarty->get_registered_object("db");
        $group = $params['group'];
        $orig = $params['orig'];
        $count = $params['count'];
        if (!isset($count) || empty($count)){
          $count = 0; 
        } else $count = $count-1;
        $ret = "";
        if (isset($group) && !empty($group)){
          $sql2 = $db->prepare("SELECT ID FROM bs_images_group WHERE ID='".$group."'");
          $res2 = $db->execute($sql2);
          if ($res2 && $res2->RecordCount() > 0){
            $sql = $db->prepare("SELECT * FROM ".DB_PREFIX."images WHERE GroupID='".$group."' ORDER BY ID ASC LIMIT ".$count.",1");
          }
        }
        if (!empty($sql)){
          $res = $db->Execute($sql);
          if ($res && $res->RecordCount() > 0){
            if ($orig=="true"){
              $file_resize = $res->fields["Image"];
            } else {
              $file_resize = $res->fields["ImageResize"];
            }
            $name = $res->fields["Name"];
          } else {
            $file_resize = "common/no_image.gif";
            $name="No photo";
          }
        } else {
          $file_resize = "common/no_image.gif";
          $name="No photo";
        }

            if (file_exists(uploadDirectory.$file_resize)){
              if ($orig=="true"){
                $ret .= uploadDirectoryURL.$file_resize;
              } else {
                $ret .= uploadDirectoryURL.$file_resize;
              }
            }
        
     unset($db);
        return $ret;
}



?>