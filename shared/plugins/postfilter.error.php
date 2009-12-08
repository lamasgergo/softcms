<?
function smarty_postfilter_error($tpl, &$smarty) {
    global $lang;
 //Include your own respective translation strings here
  $msg = "";
  if (isset($_SESSION[SES_PREFIX."error"]) && !empty($_SESSION[SES_PREFIX."error"])){
    include_once($_SERVER['DOCUMENT_ROOT'].'/shared/locale/'.$lang->getLanguage().'/error.php');
    if (isset($error[$_SESSION[SES_PREFIX."error"]])){
      $msg = $error[$_SESSION[SES_PREFIX."error"]];
    } else {
      $msg = $_SESSION[SES_PREFIX."error"];
    }
    $_SESSION[SES_PREFIX."error"] = "";
  }

  $tpl = preg_replace("/##ERROR_MESSAGE##/","<span class='error'>".$msg."</span>",$tpl);
 
 return $tpl;
}
 
?>
