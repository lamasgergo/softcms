<?php
class ContentBlocksHelper {
	
	function getForm(){
		global $smarty, $language, $db, $user;
		// content
		$sql = $db->prepare("SELECT * FROM ".DB_PREFIX."cnt_category WHERE LangID='".$user->edit_lang_id."'");
		$res = $db->Execute($sql);
		$cnames = array();
		$cids = array();
		if ($res && $res->RecordCount() > 0){
			while (!$res->EOF){
				$cnames[] = $res->fields['Name']; 
				$cids[] = $res->fields['ID'];
				$res->MoveNext();
			}
		}
		$smarty->assign("cnames", $cnames);
		$smarty->assign("cids", $cids);
		// content
		$sql = $db->prepare("SELECT * FROM ".DB_PREFIX."cnt_item WHERE LangID='".$user->edit_lang_id."'");
		$res = $db->Execute($sql);
		$names = array();
		$ids = array();
		if ($res && $res->RecordCount() > 0){
			while (!$res->EOF){
				$names[] = $res->fields['Title']; 
				$ids[] = $res->fields['ID'];
				$res->MoveNext();
			}
		}
		$smarty->assign("names", $names);
		$smarty->assign("ids", $ids);
		
		//tpl
		$tpl_names = array();
		
		$dir = realpath(dirname(__FILE__).'/../../../source/templates/design/default/content/');
		if (file_exists($dir)){
			$d = dir($dir);
			while (false !== ($entry = $d->read())) {
			   if (preg_match("/^(.+)\.tpl$/", $entry, $match)){
			   		$tpl_names[] = $match[1];
			   }
			}
			$d->close();
		}
		
		$smarty->assign("tpl_names", $tpl_names);
		$smarty->assign("tpl_ids", $tpl_names);
		
		return $smarty->fetch('helpers/blocks_modules/content.tpl',null,$language);	
	}
}
?>