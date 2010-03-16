<?php
class Categories extends TabElement {
    
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
	
	function Categories($mod_name){
	    global $form;
		$this->name=__CLASS__;
		parent::TabElement($mod_name);
		
		$this->setClassVars();
		
		// set common module path
		
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
	
	
	function getTreeValues($parent_id=0, $ret=array(), $depth=0){
		$depth++;
		$sql = "SELECT * FROM ".DB_PREFIX."content_categories WHERE ParentID='".$parent_id."' AND LangID='".$this->user->edit_lang_id."' ORDER BY ID";
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			while (!$res->EOF){
				$depth_str = '';
				for ($i=0; $i<$depth; $i++) $depth_str .= '-';
				$ret[] = array(
							'ID'   		    => $res->fields["ID"],
							'Name' 		    => $depth_str.$res->fields["Name"],
							'Description'	=> $res->fields["Description"],
							'Published'	    => $res->fields["Published"],
							'Created' 	    => $res->fields["Created"]
						);
				
				$ret = $this->getTreeValues($res->fields["ID"], $ret, $depth);
				$res->MoveNext();
			}
		}
		return $ret;
	}
	
	/* show module items*/
	function getValue(){
	    $this->smarty->assign("items_arr",$this->getTreeValues());
	    return $this->smarty->fetch($this->tpl_path.'/table.tpl',null,$this->language);
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
        //LangID
	    #$blocks_sql = "SELECT ID, Description FROM ".DB_PREFIX."lang";
	    #$this->getOptions($blocks_sql,array('ID','Description'), array('lang_ids','lang_names'));
        
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
	    
		if (!empty($id)){
			$sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."content_categories WHERE ID='".$id."'");
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
	
    function categories_form($form, $id=""){
        echo $form;
        $file = '';
		if (check_rights($form)){
			$this->formData($form,$id);
			$this->smarty->assign("form",$form);
			$this->smarty->assign("tab_prefix",$this->getName());
			$file = $this->smarty->fetch($this->tpl_module_path.'/'.$this->getName().'/form.tpl',null,$this->language);	
		}
		return $file;
	}
	
	
    function categories_add($data){
		$result = true;
		if ($this->checkRequiredFields($data)){
			isset($data['Published']) ? $published = $data['Published'] : $published = 0;
			isset($data['AllowComments']) ? $AllowComments = $data['AllowComments'] : $AllowComments = 0;
			$sql = $this->db->prepare("INSERT INTO ".DB_PREFIX."content_categories(UserID,ParentID,LangID,Name,Description,Published,Created,AllowComments) VALUES ('".$this->user->id."','".$data["ParentID"]."','".$this->user->edit_lang_id."','".$data["Name"]."','".$data["Description"]."','".$published."',NOW(), '".$AllowComments."')");
			if ($this->db->Execute($sql)){
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
	
    function categories_change($data){
		$result = true;
		if ($this->checkRequiredFields($data)){
		    isset($data['Published']) ? $published = $data['Published'] : $published = 0;
		    isset($data['AllowComments']) ? $AllowComments = $data['AllowComments'] : $AllowComments = 0;
			$sql = $this->db->prepare("UPDATE ".DB_PREFIX."content_categories SET ParentID='".$data["ParentID"]."',Name='".$data["Name"]."',Description='".$data["Description"]."',Published='".$published."', AllowComments='".$AllowComments."' WHERE ID='".$data["ID"]."'");
			if ($this->db->Execute($sql)){
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
	
    function categories_delete($data){
        $result = true;
        $ids = explode(',', $data['ids']);
        $ids = array_unique($ids); // fix

        if (count($ids)<=0) return false;
        
        $delete = array();
        foreach ($ids as $id){
            $delete[] = array('id' => $id); 
		    $delete = array_merge_recursive($this->getTreeList($id), $delete);
        }

        foreach ($delete as $delete_item){
            $ids[] = $delete_item['id'];
        }

        if (count($ids)<=0) return false;

        $ids = array_unique($ids);
        $sql = $this->db->prepare("DELETE FROM ".DB_PREFIX."content_categories WHERE id IN ('".implode("','", $ids)."')");
        $res = $this->db->Execute($sql);
        if ($res){
            $msg =  $this->lang[$this->getName()."_delete_suc"];
            $sql = $this->db->prepare("DELETE FROM ".DB_PREFIX."content WHERE CategoryID IN ('".implode("','", $ids)."')");
            $this->db->Execute($sql);
        } else {
            $msg =  $this->lang[$this->getName()."_delete_err"];
            $result = false;
        }

		return array($result, $msg);
	}
	

    function categories_publish ($id, $value)
    {
        $objResponse = new xajaxResponse();
        if (check_rights('publish')) {
            if ($value == "true") {
                $value = "1";
            } else
                $value = "0";
            if ($id != "") {
                $sql = $this->db->prepare("UPDATE " . DB_PREFIX . "cnt_category SET Published='" . $value . "' WHERE ID='" . $id . "'");
                $res = $this->db->Execute($sql);
            }
        } else
            $objResponse->addAlert($lang["per_cant_publish"]);
        return $objResponse->getXML();
    }
    
    
    function get_category_row_options ($id, $cur_id = 0, $langid = 0, $userid = '', $depth = 0, $row = array())
    {
        $depth ++;
        if ($userid != '' && $userid != 0) {
            $userid_sql = " AND UserID='" . $userid . "' ";
        } else
            $userid_sql = '';
        if ($langid != 0) {
            $langid_sql = " AND LangID='" . $langid . "' ";
        } else
            $langid_sql = "AND LangID='" . $user->edit_lang_id . "'";
        $sql = $this->db->prepare("SELECT * FROM " . DB_PREFIX . "cnt_category WHERE ParentID='" . $id . "' " . $userid_sql . " AND ID<>'" . $cur_id . "' " . $langid_sql . " ORDER BY Name ASC");
        $res = $this->db->Execute($sql);
        if ($res && $res->RecordCount() > 0) {
            while (! $res->EOF) {
                $depth_value = "";
                for ($i = 1; $i < $depth; $i ++)
                    $depth_value .= '-';
                $row[] = array($res->fields["ID"] , $depth_value , $res->fields["Name"]);
                $row = $this->get_category_row_options($res->fields["ID"], $cur_id, $langid, $userid, $depth, $row);
                $res->MoveNext();
            }
        }
        return $row;
    }
    
    function categories_showCategories ($langid, $cur_id = 0)
    {
        isset($this->lang["select_default_name"]) ? $def_value = $this->lang["select_default_name"] : "select_default_name";
        $options = '<select name="ParentID" id="ParentID">';
        $options .= '<option value="0">' . $def_value . '</option>';
        $objResponse = new xajaxResponse();
        $cat = $this->get_category_row_options(0, $cur_id, 0, $langid);
        for ($i = 0; $i < count($cat); $i ++) {
            $options .= '<option value="' . $cat[$i][0] . '">' . $cat[$i][1] . $cat[$i][2] . '</option>';
        }
        $options .= '</select>';
        $objResponse->addAssign('ParentIDDiv', 'innerHTML', $options);
        return $objResponse->getXML();
    }
}
?>