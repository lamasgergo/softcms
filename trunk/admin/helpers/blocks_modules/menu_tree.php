<?php

class menu_treeBlocksHelper {
	
	function getTreeList($parent_id=0, $ret=array(), $depth=0){
		global $db,$user;
		$depth++;
		$sql = "SELECT ID, Name FROM ".DB_PREFIX."menutree WHERE ParentID='".$parent_id."' AND LangID='".$user->edit_lang_id."' ORDER BY OrderNum";
		$res = $db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			while (!$res->EOF){
				$depth_str = '';
				for ($i=0; $i<$depth; $i++) $depth_str .= '-';
				$ret[] = array(
							'id'   => $res->fields["ID"],
							'name' => $depth_str.$res->fields["Name"]
						);
				
				$ret = menu_treeBlocksHelper::getTreeList($res->fields["ID"], $ret, $depth);
				$res->MoveNext();
			}
		}
		return $ret;
	}
	
	function getForm(){
		global $smarty, $language, $db, $user;
		$parent_arr = menu_treeBlocksHelper::getTreeList(0);
		$ids = array();
		$names = array();
		foreach ($parent_arr as $parent){
			$ids[] = $parent["id"];
			$names[] = $parent["name"];
		}
		$smarty->assign("ids",$ids);
		$smarty->assign("names",$names);
		
		return $smarty->fetch('helpers/blocks_modules/menu_tree.tpl',null,$language);	
	}
}
?>