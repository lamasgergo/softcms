<?php
require_once($_SERVER['DOCUMENT_ROOT']."/admin/common/BackendElement.php");

class Categories extends BackendElement {
    
	var $module;
	var $table;
	var $langDepended = true;
	var $gridHideItems = 'ParentID';
	var $requiredFields = 'Name';
		
	function Categories($module_name){
		$this->name=__CLASS__;
		$this->module = $module_name;
		$this->table = DB_PREFIX.'cnt_category';
		
		parent::BackendElement();
	}
	
	function prepareModifyForm(){
		// ParentID
        $parent_arr = $this->getTreeList(0);
        $parent_ids = array();
        $parent_names = array();
        foreach ($parent_arr as $parent){
        	$parent_ids[] = $parent["id"];
        	$parent_names[] = $parent["name"];
        }
        $this->smarty->assign("parent_ids",$parent_ids);
        $this->smarty->assign("parent_names",$parent_names);
	}
	
	function getTreeList($parent_id=0, $ret=array(), $depth=0){
		$depth++;
		$sql = "SELECT ID, Name FROM ".DB_PREFIX."cnt_category WHERE ParentID='".$parent_id."' AND LangID='".$this->user->edit_lang_id."' ORDER BY ID";
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			while (!$res->EOF){
				$depth_str = '';
				for ($i=0; $i<$depth; $i++) $depth_str .= '-';
				$ret[] = array(
							'id'   => $res->fields["ID"],
							'name' => $depth_str.$res->fields["Name"]
						);
				
				$ret = $this->getTreeList($res->fields["ID"], $ret, $depth);
				$res->MoveNext();
			}
		}
		return $ret;
	}
	
	function Categories_add($data){
		return $this->runAjaxAction("add", $data);
	}

	function Categories_change($data, $closeTab){
		return $this->runAjaxAction("change", $data);
	}
	
	function Categories_delete($data){
		return $this->runAjaxAction("delete", $data, false);
	}
}
?>