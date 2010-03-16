<?php

$ID = intval($_GET["id"]);



$sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."cnt_item WHERE ID='".$ID."'");
$res = $this->db->Execute($sql);
if ($res && $res->RecordCount() > 0){
  $this->smarty->assign("item_arr",$res->GetArray());
} else {
  $this->smarty->assign("item_arr",array());
}




$output = $this->smarty->display("content_print/print.tpl",null,$this->language);
exit();
?>