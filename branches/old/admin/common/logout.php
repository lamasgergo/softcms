<?
$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__).'/../../');

session_start();

include_once("../../config/config.php");

  $_SESSION[SES_PREFIX."id"]="";
  $_SESSION[SES_PREFIX."reg"]="";
  $_SESSION[SES_PREFIX."admin"]="";
  echo "<script language='javascript'>location.replace('/admin/');</script>";
?>