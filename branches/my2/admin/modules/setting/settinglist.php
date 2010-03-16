<?php

class SettingList extends TabElement{

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
   * false  : don't sort
   * 'S'    : string sorting
   * 'N'    : numeric sorting
   * 
   * example: false,'S','N',false,'S','S'
  */
  var $sort_table_fields;
  
  function SettingList($mod_name,$tabID){
    $this->name=__CLASS__;
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
	$this->sort_table_fields = "false,'S',false";
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
  }

  
  function getTabContent(){
    return $this->getValue();  
  }
  
  
  function getValue(){
      $sql = $this->db->prepare("SELECT Name, Value FROM ".DB_PREFIX."settings ORDER BY Name");
      $res = $this->db->Execute($sql);
      if ($res && $res->RecordCount() > 0){
        $this->smarty->assign("items_arr",$res->getArray());
      } else $this->smarty->assign("items_arr",array());
     return $this->smarty->fetch($this->tpl_path.'/table.tpl',null,$this->language);
  }
  
  
  function formData($form,$id=""){
    if (!empty($id)){
      $sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."settings WHERE Name='".$id."'");
      $res = $this->db->Execute($sql);
      if ($res && $res->RecordCount() > 0){
        $this->smarty->assign("items_arr",$res->getArray());
      } else $this->smarty->assign("items_arr",array());
    } else $this->smarty->assign("items_arr",array());
  }
  
  function settinglist_form($form,$id=""){
    $objResponse = new xajaxResponse();
    if (check_rights($form)){
      $this->formData($form,$id);
      $this->smarty->assign("form",$form);
      $this->smarty->assign("tab_prefix",$this->getName());
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
  
  
  function settinglist_add($data){
  	$objResponse = new xajaxResponse();
    $sql = $this->db->prepare("SELECT Name FROM ".DB_PREFIX."settings WHERE Name='".$data["Name"]."'");
    $res = $this->db->Execute($sql);
    if ($res && $res->RecordCount() > 0){
    	$msg = $this->lang[$this->getName()."_add_err2"];
    } else {
	    $sql = $this->db->prepare("INSERT INTO ".DB_PREFIX."settings (Name,Value) VALUES ('".$data["Name"]."','".$data["Value"]."')");
	    if ($this->db->Execute($sql)){
	      $msg = $this->lang[$this->getName()."_add_suc"];
	      $objResponse->addScriptCall("xajax_".$this->getName()."_refresh",$this->tabID);
	      $objResponse->addScriptCall("deleteTab",false,'parentActiveTabCount','dhtmlgoodies_tabView1');
	    } else {
	      $msg = $this->lang[$this->getName()."_add_err"];
	    }	
    }
    $objResponse->addAlert($msg);
    return $objResponse->getXML();
  }
  
  function settinglist_change($data){
    $error = false;
    $sql = $this->db->prepare(
      "UPDATE ".DB_PREFIX."settings SET Value = '".$data["Value"]."' WHERE Name='".$data["Name"]."'
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
      $objResponse->addScriptCall("xajax_".$this->getName()."_refresh",$this->tabID);
      $objResponse->addScriptCall("deleteTab",false,'parentActiveTabCount','dhtmlgoodies_tabView1');
    }
    return $objResponse->getXML();
  }
  
  function settinglist_delete($id){
    $sql = $this->db->prepare("DELETE FROM ".DB_PREFIX."settings WHERE Name='".$id."'");
    if ($this->db->Execute($sql)){
      $msg = $this->lang[$this->getName()."_delete_suc"];
    } else {
      $msg = $this->lang[$this->getName()."_delete_err"];
    }
    $objResponse = new xajaxResponse();
    $objResponse->addAlert($msg);
    $objResponse->addScriptCall("xajax_".$this->getName()."_refresh",$this->tabID);
    return $objResponse->getXML();
  }
  
  function settinglist_refresh($tab_id){
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
