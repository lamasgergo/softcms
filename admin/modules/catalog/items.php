<?php
require_once($_SERVER['DOCUMENT_ROOT']."/admin/common/BackendElement.php");
require_once(dirname(__FILE__)."/categories.php");

class Items extends BackendElement {

	var $module;
	var $table;
	var $langDepended = true;
	var $gridHideItems = 'Description, ImageGroupID, MetaAlt, MetaDescription, MetaKeywords, MetaTitle';
	var $requiredFields = 'Name, Price';

	function Items($module_name){
		$this->name=__CLASS__;
		$this->module = $module_name;
		$this->table = DB_PREFIX.'catalog';

		parent::BackendElement();
	}

	function prepareModifyForm(){
		// CategoryID
        $categories = new Categories($this->mod_name);
        $category_arr = $categories->getTreeList();
        $category_ids = array();
        $category_names = array();
        foreach ($category_arr as $data){
        	$category_ids[] = $data["id"];
        	$category_names[] = $data["name"];
        }
        $this->smarty->assign("category_ids",$category_ids);
        $this->smarty->assign("category_names",$category_names);
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

	function items_add($data){
		return $this->runAjaxAction("add", $data);
	}

	function items_change($data){
		return $this->runAjaxAction("change", $data);
	}

	function items_delete($data){
		return $this->runAjaxAction("delete", $data, false);
	}

}
?>