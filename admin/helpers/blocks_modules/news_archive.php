<?php
class news_archiveBlocksHelper {
	
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
		
		//tpl
		$tpl_names = array();
		
		$dir = realpath(dirname(__FILE__).'/../../../source/templates/design/default/news_archive/');
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
		
		return $smarty->fetch('helpers/blocks_modules/news_archive.tpl',null,$language);	
	}
}
?>