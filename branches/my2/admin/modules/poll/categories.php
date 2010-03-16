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
	
	function Categories($mod_name,$tabID){
	    global $form;
		$this->name=__CLASS__;
		$this->addXajaxFunction($this->getName()."_change");
		$this->addXajaxFunction($this->getName()."_add");
		$this->addXajaxFunction($this->getName()."_delete");
		$this->addXajaxFunction($this->getName()."_refresh");
		$this->addXajaxFunction($this->getName()."_form");
		$this->addXajaxFunction($this->getName()."_publish");
		
		parent::TabElement($mod_name);
		
		$this->setClassVars();
		
		//set current tab ID
		$this->tabID = $tabID;
		// set common module path
		
		// set template and ajax vars
		$this->setTemplateVars();
		
		
	}
	
    function setClassVars(){
	    $this->sort_table_fields = "false,'N','S','S','N','S'";
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
	    $sql = $this->db->prepare("SELECT * FROM ".POLL_PREFIX."category WHERE LangID='".$this->user->edit_lang_id."' ORDER BY ID ASC");
	    $res = $this->db->Execute($sql);
	    if ($res && $res->RecordCount() > 0){
	        $this->smarty->assign("items_arr", $res->getArray());
	    } else { 
	        $this->smarty->assign("items_arr", array());
	    }
	    return $this->smarty->fetch($this->tpl_path.'/table.tpl',null,$this->language);
	}	
	
	
    function formData($form,$id=""){
              
		if (!empty($id)){
			$sql = $this->db->prepare("SELECT * FROM ".POLL_PREFIX."category WHERE ID='".$id."'");
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
	
    function categories_form($form,$tab_id, $id=""){
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
	
	
    function categories_add($data){
		$objResponse = new xajaxResponse();
		$error = false;
		if ($this->checkRequiredFields($data)){
			isset($data['Published']) ? $published = $data['Published'] : $published = 0;
			$sql = $this->db->prepare("INSERT INTO ".POLL_PREFIX."category
				(
					LangID,
					Name,
					Description,
					Published,
					Created
				) VALUES(
					'".$this->user->edit_lang_id."',
					'".$data["Name"]."',
					'".$data["Description"]."',
					'".$published."',
					NOW()
				)");
			if ($this->db->Execute($sql)){
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
	
    function categories_change($data){
		$error = false;
		$msg = "";
		
		if ($this->checkRequiredFields($data)){
		    isset($data['Published']) ? $published = $data['Published'] : $published = 0;
			$sql = $this->db->prepare("UPDATE ".POLL_PREFIX."category SET 
					LangID='".$this->user->edit_lang_id."',
					Name='".$data["Name"]."',
					Description='".$data["Description"]."',
					Published='".$published."'
					WHERE ID='".$data["ID"]."'
			");
			if ($this->db->Execute($sql)){
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
	
    function categories_delete($id){
		$sql = $this->db->prepare("DELETE FROM ".POLL_PREFIX."category WHERE ID='".$id."'");
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
	
	function categories_refresh($tab_id){
		$objResponse = new xajaxResponse();
		$this->setClassVars();
		$this->setTemplateVars();		
		$objResponse->addScriptCall("showTab","dhtmlgoodies_tabView1",$tab_id);
		$objResponse->addAssign($this->visual_div_name,'innerHTML',$this->getValue());
		$objResponse->addScriptCall("initTableWidget","myTable","100%","480","Array(".$this->sort_table_fields.")");
		$objResponse->addScriptCall("showBody");
		return $objResponse->getXML();
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
                $sql = $this->db->prepare("UPDATE " . POLL_PREFIX . "category SET Published='" . $value . "' WHERE ID='" . $id . "'");
                $res = $this->db->Execute($sql);
            }
        } else
            $objResponse->addAlert($lang["per_cant_publish"]);
        return $objResponse->getXML();
    }
    
}
?>