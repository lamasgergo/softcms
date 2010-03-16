<?php
class GalleryBlocksHelper {
	
	function getForm(){
		global $smarty, $language, $db, $user;
		// content
		$sql = $db->prepare("SELECT * FROM ".GAL_PREFIX."category WHERE LangID='".$user->edit_lang_id."'");
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
		
				
		return $smarty->fetch('helpers/blocks_modules/gallery.tpl',null,$language);	
	}
}
?>