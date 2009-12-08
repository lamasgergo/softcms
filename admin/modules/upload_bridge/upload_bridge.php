<?php
$mod_name = "upload_bridge";

require_once(__PATH__."/admin/modules/".$mod_name."/UploadBridge.php");


$form = new UploadBridge($mod_name);
$form->setModuleName($_GET['modName']);
$form->processUpload();
$parse_main = $form->show();

?>