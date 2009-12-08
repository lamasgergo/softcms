<?php
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
	
	function Items($mod_name,$tabID){
	    global $form;
		$this->name=__CLASS__;
		$this->addXajaxFunction($this->getName()."_change");
		$this->addXajaxFunction($this->getName()."_add");
		$this->addXajaxFunction($this->getName()."_delete");
		$this->addXajaxFunction($this->getName()."_refresh");
		$this->addXajaxFunction($this->getName()."_form");
		$this->addXajaxFunction($this->getName()."_publish");
		$this->addXajaxFunction($this->getName()."_showCategories");
		$this->addXajaxFunction($this->getName()."_initEditorLite");
		
		$this->uploadDirectory = galleryUploadDirectory;
		
		parent::TabElement($mod_name);
		
		$this->setClassVars();
		
		$this->tabID = $tabID;
		
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
		$this->smarty->assign("tab_id",$this->tabID);
	}
	
	function getTabContent(){
		return $this->getValue();	
	}
	
	
	/* show module items*/
	function getValue(){
	    $sql = $this->db->prepare("SELECT * FROM ".GAL_PREFIX."item WHERE LangID='".$this->user->edit_lang_id."' ORDER BY ID ASC");
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
		$sql = "SELECT ID, Name FROM ".GAL_PREFIX."category WHERE ParentID='".$parent_id."' AND LangID='".$this->user->edit_lang_id."' ORDER BY ID";
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
			$sql = $this->db->prepare("SELECT * FROM ".GAL_PREFIX."item WHERE ID='".$id."'");
			$res = $this->db->Execute($sql);
			if ($res && $res->RecordCount() > 0){
				// images
          		$this->smarty->assign("uploaded_files",$this->showImagePreview($res->fields["ImageGroupID"], galleryUploadDirectoryURL, galleryUploadDirectory));
          		
				$values = $res->getArray();
				$this->smarty->assign("items_arr",$values);
				
			} else $this->smarty->assign("items_arr",array());
		} else {
			$this->smarty->assign("items_arr",array());
			$this->smarty->assign("after_checked","checked");
		}
	}
	
    function items_form($form,$tab_id, $id=""){
		$objResponse = new xajaxResponse();
		if (check_rights($form)){
			$this->formData($form,$id);
			$this->smarty->assign("form",$form);
			$this->smarty->assign("tab_prefix",$this->getName());
			$this->smarty->assign("tab_id",$tab_id);
			$file = $this->smarty->fetch($this->tpl_module_path.'/'.$this->getName().'/form.tpl',null,$this->language);	
			$objResponse->addScriptCall("deleteTab",false,'parentActiveTabCount','dhtmlgoodies_tabView1');
			if (isset($this->lang["tab_".$this->getName()."_".$form])){
				$tab_title = $this->lang["tab_".$this->getName()."_".$form];
			} else $tab_title = "tab_".$this->getName()."_".$form;
			$cnt = $objResponse->addScript("tabView_countTabs");
		    $objResponse->addScriptCall("createNewTab","dhtmlgoodies_tabView1",$tab_title,$file,'');
		}
		return $objResponse->getXML();
	}
	
	
    function items_add($data){
		$objResponse = new xajaxResponse();
		$error = false;
		if ($this->checkRequiredFields($data)){
			isset($data['Published']) ? $published = $data['Published'] : $published = 0;
			$sql = $this->db->prepare("INSERT INTO ".GAL_PREFIX."item
				(
					UserID,
					CategoryID,
					LangID,
					Name,
					Description,
					Published,
					Created,
					MetaAlt,
					MetaKeywords,
					MetaDescription,
					MetaTitle
				) VALUES(
					'".$this->user->id."',
					'".$data["CategoryID"]."',
					'".$this->user->edit_lang_id."',
					'".$data["Name"]."',
					'".$data["Description"]."',
					'".$published."',
					NOW(),
					'".$data["MetaAlt"]."',
					'".$data["MetaKeywords"]."',
					'".$data["MetaDescription"]."',
					'".$data["MetaTitle"]."'
				)");
			if ($this->db->Execute($sql)){
				$id = $this->db->Insert_ID(ADB_PREFIX."car","ID");
		        if (isset($id) && !empty($id)){
		          $ImageGroupID = $this->addUploadedFiles(0, galleryUploadDirectory);
		          $sql = $this->db->prepare("UPDATE ".GAL_PREFIX."item SET ImageGroupID='".$ImageGroupID."' WHERE ID='".$id."'");
		          $this->db->Execute($sql);
		        }
				$msg = $this->lang[$this->getName()."_add_suc"];
			} else {
				$msg = $this->lang[$this->getName()."_add_err"];
				$error = true;
			}
		} else {
      		$msg = $this->lang["requered_data_absent"];
      		$error = true; 
    	}
		$objResponse->addAlert($msg);
		if (!$error){
		    $objResponse->addScriptCall("hideBody");
		    $objResponse->addScript("progressStep('40');");
			$objResponse->addScriptCall("xajax_".$this->getName()."_refresh",$data['tab_id']);
			$objResponse->addScript("progressStep('80');");
			$objResponse->addScriptCall("deleteTab",false,'parentActiveTabCount','dhtmlgoodies_tabView1');
			$objResponse->addScript("progressStep('100');");
		}
		return $objResponse->getXML();
	}
	
    function items_change($data){
		$error = false;
		$msg = "";
		
		if ($this->checkRequiredFields($data)){
		    isset($data['Published']) ? $published = $data['Published'] : $published = 0;
			$sql = $this->db->prepare("UPDATE ".GAL_PREFIX."item SET 
					CategoryID='".$data["CategoryID"]."',
					Name='".$data["Name"]."',
					Description='".$data["Description"]."',
					Published='".$published."',
					MetaAlt='".$data["MetaAlt"]."',
					MetaKeywords='".$data["MetaKeywords"]."',
					MetaDescription='".$data["MetaDescription"]."',
					MetaTitle='".$data["MetaTitle"]."'
					WHERE ID='".$data["ID"]."'
			");
			if ($this->db->Execute($sql)){
				if (isset($data["ID"]) && !empty($data["ID"])){
		          $ImageGroupID = $this->addUploadedFiles($data["ImageGroupID"], galleryUploadDirectory);
		          $sql = $this->db->prepare("UPDATE ".GAL_PREFIX."item SET ImageGroupID='".$ImageGroupID."' WHERE ID='".$data["ID"]."'");
		          $this->db->Execute($sql);
		        }
				$msg = $this->lang[$this->getName()."_change_suc"];
			} else {
				$error = true;
				$msg = $this->lang[$this->getName()."_change_err"];
			}
		} else {
			$error = true;
      		$msg = $this->lang["requered_data_absent"]; 
    	}
		$objResponse = new xajaxResponse();
		$objResponse->addAlert($msg);
		if (!$error){
		    $objResponse->addScriptCall("hideBody");
		    $objResponse->addScript("progressStep('40');");
			$objResponse->addScriptCall("xajax_".$this->getName()."_refresh",$data['tab_id']);
			$objResponse->addScript("progressStep('80');");
			$objResponse->addScriptCall("deleteTab",false,'parentActiveTabCount','dhtmlgoodies_tabView1');
			$objResponse->addScript("progressStep('100');");
		}
		return $objResponse->getXML();
	}
	
    function items_delete($id){
	    $sql = $this->db->prepare("SELECT ImageGroupID FROM ".GAL_PREFIX."item WHERE ID='".$id."'");
	    $res = $this->db->Execute($sql);
	    if ($res && $res->RecordCount() > 0){
	      $this->deleteImagesGroup($res->fields["ImageGroupID"], galleryUploadDirectory); 
	    }
	    
		$sql = $this->db->prepare("DELETE FROM ".GAL_PREFIX."item WHERE ID='".$id."'");
		if ($this->db->Execute($sql)){
			$msg = $this->lang[$this->getName()."_delete_suc"];
		} else {
			$msg = $this->lang[$this->getName()."_delete_err"];
		}
		$objResponse = new xajaxResponse();
		$objResponse->addAlert($msg);
		$objResponse->addScriptCall("xajax_".$this->getName()."_refresh",$data['tab_id']);
		return $objResponse->getXML();
	}
	
	function items_refresh($tab_id){
		$objResponse = new xajaxResponse();
		$this->setClassVars();
		$this->setTemplateVars();		
		$objResponse->addScriptCall("showTab","dhtmlgoodies_tabView1",$tab_id);
		$objResponse->addAssign($this->visual_div_name,'innerHTML',$this->getValue());
		$objResponse->addScriptCall("initTableWidget","myTable","100%","480","Array(".$this->sort_table_fields.")");
		$objResponse->addScriptCall("showBody");
		return $objResponse->getXML();
		
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
                $sql = $this->db->prepare("UPDATE " . GAL_PREFIX . "item SET Published='" . $value . "' WHERE ID='" . $id . "'");
                $res = $this->db->Execute($sql);
            }
        } else
            $objResponse->addAlert($lang["per_cant_publish"]);
        return $objResponse->getXML();
    }
    
    
}
?>