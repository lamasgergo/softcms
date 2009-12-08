<?php
class BannersBlocksHelper {
	
	function getForm(){
		global $smarty, $language, $db, $user;
		// content
		$sql = $db->prepare("SELECT * FROM ".DB_PREFIX."site_banners_group");
		$res = $db->Execute($sql);
		$names = array();
		$ids = array();
		if ($res && $res->RecordCount() > 0){
			while (!$res->EOF){
				$names[] = $res->fields['Name']; 
				$ids[] = $res->fields['ID'];
				$res->MoveNext();
			}
		}
		$smarty->assign("names", $names);
		$smarty->assign("ids", $ids);
		
				
		return $smarty->fetch('helpers/blocks_modules/banners.tpl',null,$language);	
	}
}
?>