<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/admin/modules/menu_tree/menutree.php';

class Items extends TabElement {
    
	/* Name of a Tab Element */
	var $name;

	/* Body of a Tab Element */
	var $value;

	/* Action menu for Tab Element */
	var $menu;

	/* Data Filter for Tab Element */
	var $filter;

	/* Name of a DIV where Tab Element will parsed */
	var $visual_div_name;

	/* Smarty object */
	var $smarty;

	/* Lang array with localization vars */
	var $lang;

	/* Var with lang ID for smarty templates engine */
	var $language;

	/* Main module name */
	var $mod_name;

	/* JS sortable params:
	 * false 	: don't sort
	 * 'S'		: string sorting
	 * 'N'		: numeric sorting
	 * 
	 * example: false,'S','N',false,'S','S'
	*/
	var $sort_table_fields;
	
	function Items($mod_name){
	    global $form;
		$this->name=__CLASS__;

		parent::TabElement($mod_name);
		
		$this->setClassVars();
		
		// set template and ajax vars
		$this->setTemplateVars();
		
		
	}
	
    function setClassVars(){
	    $this->sort_table_fields = "false,'S'";
	    $this->tpl_path = strtolower($this->mod_name).'/'.strtolower($this->name);
	}
	
	function getName(){
		return strtolower(__CLASS__);
	}
	
	//set common template vars
	function setTemplateVars(){
		$this->smarty->assign("prefix",$this->mod_name);	
		$this->smarty->assign("tab_prefix",$this->getName());	
		$this->smarty->assign("sort_table_fields",$this->sort_table_fields);
	}
	
	function getTabContent(){
		return $this->getValue();	
	}
	
	
	/* show module items*/
	function getValue(){
	    $sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."content WHERE LangID='".$this->user->edit_lang_id."' ORDER BY ID ASC");
	    $res = $this->db->Execute($sql);
	    if ($res && $res->RecordCount() > 0){
	        $this->smarty->assign("items_arr", $res->getArray());
	    } else { 
	        $this->smarty->assign("items_arr", array());
	    }
	    return $this->smarty->fetch($this->tpl_path.'/table.tpl', null, $this->language);
	}	
	
	
	
	function getTreeList($parent_id=0, $ret=array(), $depth=0){
		$depth++;
		$sql = "SELECT ID, Name FROM ".DB_PREFIX."content_categories WHERE ParentID='".$parent_id."' AND LangID='".$this->user->edit_lang_id."' ORDER BY ID";
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
	
    function formData($form,$id=""){
	    // MenuID
		$parent_arr = MenuTree::getTreeList(0);
		$parent_ids = array();
		$parent_names = array();
		foreach ($parent_arr as $parent){
			$parent_ids[] = $parent["id"];
			$parent_names[] = $parent["name"];
		}
		$this->smarty->assign("menu_ids",$parent_ids);
		$this->smarty->assign("menu_names",$parent_names);

        // ParentID
        $parent_arr = $this->getTreeList(0);
        $parent_ids = array();
        $parent_names = array();
        foreach ($parent_arr as $parent){
        	$parent_ids[] = $parent["id"];
        	$parent_names[] = $parent["name"];
        }
        $this->smarty->assign("category_ids",$parent_ids);
        $this->smarty->assign("category_names",$parent_names);
	    
		if (!empty($id)){
			$sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."content WHERE ID='".$id."'");
			$res = $this->db->Execute($sql);
			if ($res && $res->RecordCount() > 0){
				
				$values = $res->getArray();
				$this->smarty->assign("items_arr",$values);
				
			} else $this->smarty->assign("items_arr",array());
		} else {
			$this->smarty->assign("items_arr",array());
			$this->smarty->assign("after_checked","checked");
		}
	}
	
    function items_form($form, $id=""){
        $file = '';
		if (check_rights($form)){
			$this->formData($form,$id);
			$this->smarty->assign("form",$form);
			$this->smarty->assign("tab_prefix",$this->getName());
			$file = $this->smarty->fetch($this->tpl_module_path.'/'.$this->getName().'/form.tpl',null,$this->language);
		}
		return $file;
	}
	
	
    function items_add($data){
		$result = true;
		$error = false;
		if ($this->checkRequiredFields($data)){
			isset($data['Published']) ? $published = $data['Published'] : $published = 0;
			if (!isset($data['LoginRequired'])) $data['LoginRequired'] = 0;
			if (!isset($data['AllowComments'])) $data['AllowComments'] = 0;
			
			$sql = $this->db->prepare(
				"INSERT INTO ".DB_PREFIX."content(
					CategoryID,
					UserID,
					LangID,
					Title,
					Short_Text,
					Full_Text,
					Published,
					Created,
					MetaAlt,
					MetaKeywords,
					MetaDescription,
					MetaTitle,
					LoginRequired,
					AllowComments) 
					VALUES(
					'".$data["CategoryID"]."',
					'".$this->user->id."',
					'".$this->user->edit_lang_id."',
					'".mysql_escape_string($data["Title"])."',
					'".mysql_escape_string($data["Short_Text"])."',
					'".mysql_escape_string($data["Full_Text"])."',
					'".$published."',
					'".$data["Created"]."',
					'".$data["MetaAlt"]."',
					'".$data["MetaKeywords"]."',
					'".$data["MetaDescription"]."',
					'".$data["MetaTitle"]."',
					'".$data["LoginRequired"]."',
					'".$data["AllowComments"]."'
					)
				"
			);

			if ($this->db->Execute($sql)){
				$id = $this->db->Insert_ID(ADB_PREFIX."car","ID");
		        if (isset($id) && !empty($id)){
			        if (isset($data['MenuID']) && $data['MenuID']!=0){
						$link = '/index.php?'.MODULE.'=content&iid='.$id;
						$sql = $this->db->prepare("UPDATE ".DB_PREFIX."menutree SET Link = '".$link."' WHERE ID='".$data["MenuID"]."'");
						$this->db->Execute($sql);
					}
		        }
				$msg = $this->lang[$this->getName()."_add_suc"];
			} else {
				$msg = $this->lang[$this->getName()."_add_err"];
				$result = false;
			}
		} else {
      		$msg = $this->lang["requered_data_absent"];
      		$result = false;
    	}

        return array($result, $msg);
	}
	
	function items_change($data, $no_reload=false){
		$result = true;
		
		if ($this->checkRequiredFields($data)){
		    isset($data['Published']) ? $published = $data['Published'] : $published = 0;
			if (!isset($data['LoginRequired'])) $data['LoginRequired'] = 0;
			if (!isset($data['AllowComments'])) $data['AllowComments'] = 0;
			$sql = $this->db->prepare(
				"UPDATE ".DB_PREFIX."content SET
						CategoryID='".$data["CategoryID"]."', 
						Title='".mysql_escape_string($data["Title"])."',
						Short_Text='".mysql_escape_string($data["Short_Text"])."', 
						Full_Text='".mysql_escape_string($data["Full_Text"])."', 
						Published='".$published."', 
						Created='".$data["Created"]."', 
						MetaAlt='".$data["MetaAlt"]."', 
						MetaKeywords='".$data["MetaKeywords"]."', 
						MetaDescription='".$data["MetaDescription"]."', 
						MetaTitle='".$data["MetaTitle"]."',
						LoginRequired='".$data["LoginRequired"]."',
						AllowComments='".$data["AllowComments"]."'
						WHERE ID='".$data["ID"]."'"
			);
			if ($this->db->Execute($sql)){
				if (isset($data['MenuID']) && $data['MenuID']!=0){
					$link = '/index.php?'.MODULE.'=content&iid='.$data['ID'];
					$sql = $this->db->prepare("UPDATE ".DB_PREFIX."menutree SET Link = '".$link."' WHERE ID='".$data["MenuID"]."'");
					$this->db->Execute($sql);
				}
				$msg = $this->lang[$this->getName()."_change_suc"];
			} else {
				$result = false;
				$msg = $this->lang[$this->getName()."_change_err"];
			}
		} else {
			$result = false;
      		$msg = $this->lang["requered_data_absent"]; 
    	}

        return array($result, $msg);
	}
	
    function items_delete($id){
        $result = true;
		$sql = $this->db->prepare("DELETE FROM ".DB_PREFIX."content WHERE ID='".$id."'");
		if ($this->db->Execute($sql)){
			$msg = $this->lang[$this->getName()."_delete_suc"];
		} else {
			$msg = $this->lang[$this->getName()."_delete_err"];
            $result = false;
		}
		return array($result, $msg);
	}
	
    function items_publish ($id, $value)
    {
        $objResponse = new xajaxResponse();
        if (check_rights('publish')) {
            if ($value == "true") {
                $value = "1";
            } else
                $value = "0";
            if ($id != "") {
                $sql = $this->db->prepare("UPDATE " . DB_PREFIX . "cnt_item SET Published='" . $value . "' WHERE ID='" . $id . "'");
                $res = $this->db->Execute($sql);
            }
        } else
            $objResponse->addAlert($lang["per_cant_publish"]);
        return $objResponse->getXML();
    }
    
    
}
?>