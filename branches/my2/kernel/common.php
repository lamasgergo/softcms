<?

function showBreadCrumbs($path = array()){
global $smarty, $language, $lang;
	$smarty->assign('path', $path);
	return $smarty->fetch("breadcrumbs/breadcrumbs.tpl", null, $language);
}

function image_preview($item,$count='0',$width='',$height=''){
  global $db;
  $ret = "";
  if ($count!="0"){
    $count=$count-1;
  }
  $objResponse = new xajaxResponse();
  if (isset($item) && !empty($item)){
     $sql = $db->prepare("SELECT * FROM ".DB_PREFIX."images WHERE GroupID='".$item."' ORDER BY ID ASC LIMIT ".$count.",1");
  }
  if (!empty($sql)){
    $res = $db->Execute($sql);
    if ($res && $res->RecordCount() > 0){
      $file_resize = $res->fields["Image"];
      $name = $res->fields["Name"];
      if (file_exists(uploadDirectory.$file_resize)){
        $ret .= "<a href='".uploadDirectoryURL.$file_resize."' target='_blank'>";
        $ret .= "<img src='".uploadDirectoryURL.$file_resize."'  border='0' title='".$name."' alt='".$name."'";
        $ret .= get_ratio(uploadDirectory.$file_resize,$width,$height);
        $ret .= ">";
        $ret .= "</a>";
      }
    }
  }
  $objResponse->addAssign("show_preview","innerHTML",$ret);
  return $objResponse->getXML();
}

function get_ratio($img,$width="",$height=""){
  if(!file_exists($img)) return false;
  if (empty($width) && empty($height)){
    $width = defaut_image_width;
  }
  $im = @getimagesize($img);
  // $im[0] - width; $im[1] - height
  if ($im[0]>$im[1]){
	if ($width!=''){
		return "width='".($width-2)."'";
	} else {
		return "width='".($im[0])."'";
	}
    return "width='".($width-2)."'";
  }
  if ($im[0]<$im[1]){
	if ($height!=''){
		return "height='".($height-2)."'";
	} else {
		return "height='".($im[1])."'";
	}
  }
  if ($im[0]==$im[1]){
    if ($width!=''){
		return "width='".($width-2)."'";
	} else {
		return "width='".($im[0])."'";
	}
  }
  return "";
}

function pager($sql,$page,$max_per_page){
  global $db,$smarty,$language,$lang;
  $sql = $db->prepare($sql);
  $res = $db->execute($sql);
  $count = $res->RecordCount();
  $all = floor($count/$max_per_page);
  if (($count%$max_per_page)!=0) $all++;
  $nav=navigator($page,$all);
  $smarty->assign('page',$lang["page"]);
  $smarty->assign('NLeft',$nav[0]);
  $smarty->assign('NPages',$nav[1]);
  $smarty->assign('NRight',$nav[2]);
  return $smarty->fetch("pager/pager.tpl",null,$language);
}

function insert_link_page($link,$page){
  return preg_replace("/##page##/",$page,$link);
}


function navigator($curpage,$maxpage) {
  //max pages to show at once
  $step = 3;

  $pages='';

  $url = $_SERVER["REQUEST_URI"];
  if (MOD_REWRITE){
    if (!preg_match("/\/page\/(\d+)\//",$url)){
      $link = preg_replace("/^(.+)\/index\.html$/","\\1/page/##page##/index.html",$url);
    } else {
      $link = preg_replace("/\/page\/(\d+)\//","/page/##page##/",$url);
    }
  } else {
    if (!preg_match("/page\=(\d+)/",$url)){
      $link= $url."&page=##page##";
    } else {
      $link = preg_replace("/page\=(\d+)/","page=##page##",$url);
    }
  }
  $left=$right='';

  //get start page to show
  $start = $step*floor($curpage/$step);

  //form links with numbers
  for ($i=$start; $i<($start+$step); $i++) {

    if ($i==$maxpage) break;
    if ($i==$curpage){
      $pages.=" <span style='color:white; font-family: Tahoma;font-size: 12px; text-decoration:none;'>".($i+1)."</span>";
    } else {
      $pages.=" <a href='".insert_link_page($link,$i)."' style='color:white; font-weight:bold; font-family: Tahoma;font-size: 12px; text-decoration:none;'>".($i+1)."</a>";
    }
  }

  //add '<<' and '>>' symbles
  if ($maxpage>$step) {

    //right edge
    if ($start==0) $right = "<a href='".insert_link_page($link,$step)."' style='color:white; font-weight:bold; font-family: Tahoma;font-size: 12px; text-decoration:none;'>&gt;&gt;</a>";
    //left edge
    else if
    (($start+$step)>=$maxpage) $left = "<a href='".insert_link_page($link,$start-1)."' style='color:white; font-weight:bold; font-family: Tahoma;font-size: 12px; text-decoration:none;'>&lt;&lt;</a>";
    //mean
    else {
      $left = "<a href='".insert_link_page($link,$start-1)."' style='color:white; font-weight:bold; font-family: Tahoma;font-size: 12px; text-decoration:none;'>&lt;&lt;</a>";
      $right = "<a href='".insert_link_page($link,$start+$step)."' style='color:white; font-weight:bold; font-family: Tahoma;font-size: 12px; text-decoration:none;'>&gt;&gt;</a>";
    }
  }
  return array($left,$pages,$right);
}

function post_navigator($curpage,$maxpage,$form) {
  //max pages to show at once
  $step = 3;

  $pages='';


  $left=$right='';
//get start page to show
  $start = $step*floor($curpage/$step);

  //form links with numbers
  for ($i=$start; $i<($start+$step); $i++) {
    
    if ($i==$maxpage) break;
    ($i==$curpage) ? $pages.=" <span style='color:white; font-family: Tahoma;font-size: 12px; text-decoration:none;'>".($i+1)."</span>" : $pages.=" <a href=\"javascript:document.forms['$form'].elements['page'].value=$i; document.forms['$form'].submit();void(0);\" style='color:white; font-weight:bold; font-family: Tahoma;font-size: 12px; text-decoration:none;' onMouseOver=\"window.status=''; return true\">".($i+1)."</a>";
  }

//add '<<' and '>>' symbles
  if ($maxpage>$step) {

//right edge
    if ($start==0) $right = "<a href=\"javascript:document.forms['$form'].elements['page'].value=$step; document.forms['$form'].submit();void(0);\" style='color:white; font-weight:bold; font-family: Tahoma;font-size: 12px; text-decoration:none;' onMouseOver=\"window.status=''; return true\">&gt;&gt;</a>";
//left edge
    else if (($start+$step)>=$maxpage) $left = "<a href=\"javascript:document.forms['$form'].elements['page'].value=".($start-1)."; document.forms['$form'].submit();void(0);\" style='color:white; font-weight:bold; font-family: Tahoma;font-size: 12px; text-decoration:none;' onMouseOver=\"window.status=''; return true\">&lt;&lt;</a>";
//mean
    else {
      $left = "<a href=\"javascript:document.forms['$form'].elements['page'].value=".($start-1)."; document.forms['$form'].submit();void(0);\" style='color:white; font-weight:bold; font-family: Tahoma;font-size: 12px; text-decoration:none;' onMouseOver=\"window.status=''; return true\">&lt;&lt;</a>";
      $right = "<a href=\"javascript:document.forms['$form'].elements['page'].value=".($start+$step)."; document.forms['$form'].submit();void(0);\" style='color:white; font-weight:bold; font-family: Tahoma;font-size: 12px; text-decoration:none;' onMouseOver=\"window.status=''; return true\">&gt;&gt;</a>";
    }
  }
  return array($left,$pages,$right);
}

function get_categories_row($id,$shop_id="",$row = "", $depth = 0){
  global $db, $smarty,$language,$LangID;
  $depth++;
  if ($user->admin){
    if($shop_id!=""){
      $sql = $db->prepare("SELECT * FROM ".SDB_PREFIX."category WHERE LangID='".$LangID."' AND ParentID='".$id."' AND ShopID='".$shop_id."' ORDER BY Name ASC");
    } else {
      $sql = $db->prepare("SELECT * FROM ".SDB_PREFIX."category WHERE LangID='".$LangID."' AND ParentID='".$id."' ORDER BY Name ASC");
    }
  } else {
    if ($shop_id!=""){
      $sql = $db->prepare("SELECT * FROM ".SDB_PREFIX."category WHERE LangID='".$LangID."' AND ParentID='".$id."' AND ShopID='".$shop_id."' ORDER BY Name ASC");
    } else {
      $sql = $db->prepare("SELECT * FROM ".SDB_PREFIX."category WHERE LangID='".$LangID."' AND ParentID='".$id."' ORDER BY Name ASC");
    }
  }
  $res = $db->execute($sql);
  if ($res && $res->RecordCount() > 0){
    while (!$res->EOF){
      $depth_value = "";
      for ($i=1;$i<$depth;$i++) $depth_value.='&nbsp;&nbsp;';
      $smarty->assign("depth",$depth_value);
      $smarty->assign("ID",$res->fields["ID"]);
      $smarty->assign("Name",$res->fields["Name"]);
      $row .= $smarty->fetch('shop/category_row.tpl', null, $language);
      #if (get_category_row($res->fields["ID"],$row,$depth)){
      $row = get_categories_row($res->fields["ID"],$shop_id,$row,$depth);
      #}

      $res->MoveNext();
    }
  } else {
    return $row;
    #return false;
  }

  return $row;
}



function send_email($email, $subject, $Info, $from_email="info@diesel.org.ua", $from_name="diesel.org.ua form"){
global $smarty, $language;
        include_once($GLOBALS['directory_mail']."/class.phpmailer.php");

        $mail = new phpmailer();

        $mail->Mailer = "smtp";
        $mail->IsHTML(true);
        $mail->PluginDir = $GLOBALS['directory_mail']."/";
        $mail->SMTPAuth = false;
        $mail->Host = $GLOBALS['smtp_host'];
        $mail->Port = $GLOBALS['smtp_port'];
        $mail->Username = $GLOBALS['smtp_username'];
        $mail->Password = $GLOBALS['smtp_pass'];


        $smarty->assign("BODY", $Info);

        $message = $smarty->fetch('index_lite.tpl', null, $language);
        $mail->Body = $message;

        $mail->From = $from_email;
        $mail->FromName = $from_name;
        $mail->AddAddress($email);
        $mail->CharSet = $GLOBALS['mail_charset'];
        $mail->Subject = $subject;

        if($mail->Send()){
                return true;
        } else {
                $mail->Mailer = "mail";
                if ($mail->Send()){
                        return true;
                } else return false;
        }

}

function getConfigValue($name){
	global $db;
	$sql = $db->prepare("SELECT Value FROM ".DB_PREFIX."settings WHERE Name='".$name."'");
  	$res = $db->Execute($sql);
	$val = "";
  	if ($res && $res->RecordCount() > 0){
    	$val = trim($res->fields["Value"]);
  	}
  	return $val;
}

function send_request($data){
global $lang;
	$form_data = array();
	foreach ($data as $key=>$value){
		if (preg_match("/^req\_.*$/", $key) && $key!='send_request'){
			$form_data[$key] = $value;
		}
	}
	
	if (count($form_data) > 0){
		$body = '<style>
					table{
						font-family: Tahoma;
						font-size: 11px;
						border-collapse: collapse;
						border: 1px solid #C0C0C0;
					}
					th{
						background-color: #C9C9C9;
						font-weight: bold;
					}
					td{
						border: 1px solid #C0C0C0;
					}
				</style>';
		$body .= '<table border="1" cellpadding="5" cellspacing="0">';
		foreach ($form_data as $key=>$value){
			$body .= '<tr><th>';
			if (isset($lang[$key])){
				$body .= $lang[$key];
			} else $body .= $key;
			$body .= ' : </th><td>'.preg_replace("/\n/", "<br><br>", $value)."</td></tr>";
		}
		$body .= '</table>';
		if (send_email(adminEmail, $lang['req_form'], $body, infoFromEmail, infoFromEmailName)){
			header("content-type: text/html; charset=UTF-8;");
			echo '<script language="javascript">alert("'.$lang['letter_sended_successfully'].'"); location.replace("'.$_SERVER['REQUEST_URI'].'");</script>';
		} else {
			echo '<script language="javascript">alert("'.$lang['letter_sended_failed'].'");location.replace("'.$_SERVER['REQUEST_URI'].'");</script>';
		}
	}
}

?>