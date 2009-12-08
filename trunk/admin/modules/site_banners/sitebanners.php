<?php

class SiteBanners extends TabElement{

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
	
	
	function SiteBanners($mod_name,$tabID){
		$this->name=__CLASS__;
		$this->sort_table_fields = "false,'S','S'";
		$this->addXajaxFunction($this->getName()."_change");
		$this->addXajaxFunction($this->getName()."_add");
		$this->addXajaxFunction($this->getName()."_delete");
		$this->addXajaxFunction($this->getName()."_refresh");
		$this->addXajaxFunction($this->getName()."_form");
		
		parent::TabElement($mod_name);
		
		$this->setClassVars();
		
		//set current tab ID
		$this->tabID = $tabID;
		
		// set template and ajax vars
		$this->setTemplateVars();
	}
	
	function setClassVars(){
		//set current tab ID
		$this->tabID = $tabID;
		// set common module path
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
	
	function getValue(){
	    $sql = $this->db->prepare("SELECT b.ID as ID,g.Name as GroupID, b.Code FROM ".DB_PREFIX."site_banners as b LEFT JOIN ".DB_PREFIX."site_banners_group as g ON (g.ID=b.GroupID)");
	    $res = $this->db->Execute($sql);
	    if ($res && $res->RecordCount() > 0){
	    	$this->smarty->assign("items_arr",$res->getArray());
	    } else $this->smarty->assign("items_arr",array());
	    return $this->smarty->fetch($this->tpl_path.'/table.tpl',null,$this->language);
	}
	
	function formData($form,$id=""){
		// BannersGroup
	    $sql = $this->db->prepare("SELECT ID,Name FROM ".DB_PREFIX."site_banners_group ORDER BY Name ASC");
	    $res = $this->db->Execute($sql);
	    $group_ids = array();
	    $group_names = array();
	    if ($res && $res->RecordCount() > 0){
	      while (!$res->EOF){
	        array_push($group_ids,$res->fields["ID"]);
	        array_push($group_names,$res->fields["Name"]);
	        $res->MoveNext();
	      }
	    }
	    $this->smarty->assign("GroupID_ids",$group_ids);
	    $this->smarty->assign("GroupID_names",$group_names);
		
		if (!empty($id)){
			$sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."site_banners WHERE ID='".$id."'");
			$res = $this->db->Execute($sql);
			if ($res && $res->RecordCount() > 0){
				$this->smarty->assign("items_arr",$res->getArray());
			} else $this->smarty->assign("items_arr",array());
		} else $this->smarty->assign("items_arr",array());
	}
	
	function sitebanners_form($form,$tab_id,$id=""){
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

	
	function sitebanners_add($data){
		$sql = $this->db->prepare("INSERT INTO ".DB_PREFIX."site_banners (GroupID,Code) VALUES ('".$data["GroupID"]."','".$data["Code"]."')");
		$objResponse = new xajaxResponse();			
		if ($this->db->Execute($sql)){
			$msg = $this->lang[$this->getName()."_add_suc"];
			$objResponse->addScriptCall("xajax_".$this->getName()."_refresh",$data['tab_id']);
			$objResponse->addScriptCall("deleteTab",false,'parentActiveTabCount','dhtmlgoodies_tabView1');
		} else {
			$msg = $this->lang[$this->getName()."_add_err"];
		}
		$objResponse->addAlert($msg);
		return $objResponse->getXML();
	}
	
	function sitebanners_change($data){
		$error = false;
		$sql = $this->db->prepare(
			"UPDATE ".DB_PREFIX."site_banners SET GroupID = '".$data["GroupID"]."', Code='".$data["Code"]."' WHERE ID='".$data["ID"]."'
		");
		if ($this->db->Execute($sql)){
			$msg = $this->lang[$this->getName()."_change_suc"];
		} else {
			$error = true;
			$msg = $this->lang[$this->getName()."_change_err"];
		}
		$objResponse = new xajaxResponse();
		$objResponse->addAlert($msg);
		if (!$error){
			$objResponse->addScriptCall("xajax_".$this->getName()."_refresh",$data['tab_id']);
			$objResponse->addScriptCall("deleteTab",false,'parentActiveTabCount','dhtmlgoodies_tabView1');
		}
		return $objResponse->getXML();
	}
	
	function sitebanners_delete($id){
		$sql = $this->db->prepare("DELETE FROM ".DB_PREFIX."site_banners WHERE ID='".$id."'");
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
	
	function sitebanners_refresh($tab_id){
		$objResponse = new xajaxResponse();
		$this->setClassVars();
		$this->setTemplateVars();		
		$objResponse->addScriptCall("showTab","dhtmlgoodies_tabView1",$tab_id);
		$objResponse->addAssign($this->visual_div_name,'innerHTML',$this->getValue());
		$objResponse->addScriptCall("initTableWidget","myTable","100%","480","Array(".$this->sort_table_fields.")");
		return $objResponse->getXML();
	}
}
?>
