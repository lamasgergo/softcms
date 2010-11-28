<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/admin/modules/menu_tree/menutree.php';

class BlocksManager extends TabElement{

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
	var $moduleName;

	/* JS sortable params:
	 * false 	: don't sort
	 * 'S'		: string sorting
	 * 'N'		: numeric sorting
	 * 
	 * example: false,'S','N',false,'S','S'
	*/
	var $sort_table_fields;
	
	function BlocksManager($moduleName,$tabID){
		$this->name=__CLASS__;
		$this->addXajaxFunction($this->getName()."_change");
		$this->addXajaxFunction($this->getName()."_add");
		$this->addXajaxFunction($this->getName()."_delete");
		$this->addXajaxFunction($this->getName()."_refresh");
		$this->addXajaxFunction($this->getName()."_form");
		$this->addXajaxFunction($this->getName()."_show_design");
		$this->addXajaxFunction($this->getName()."_copyform");
		$this->addXajaxFunction($this->getName()."_copy");
		
		parent::TabElement($mod_name);
		
		$this->setClassVars();
		
		//set current tab ID
		$this->tabID = $tabID;
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
		$this->smarty->assign("tab_id",$this->tabID);
	}
	
	function getTabContent(){
		return $this->getData();
	}
	
	
	
	
	
	/* show module items*/
	function getData(){
	    $items = array();
	    $sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."blocks WHERE langID='".$this->user->edit_lang_id."'");
	    $res = $this->db->Execute($sql);
	    if ($res && $res->RecordCount() > 0){
	        $items = $res->getArray();    
	    }
	    $this->smarty->assign("items_arr",$items);
	    return $this->smarty->fetch($this->tpl_path.'/table.tpl',null,$this->language);
	}	
	
	
		
	function formData($form,$id=""){
			
		/* lang */
//		$sql = $this->db->prepare ( "SELECT * FROM " . DB_PREFIX . "lang ORDER BY ID ASC" ) ;
//		$res = $this->db->Execute ( $sql ) ;
//		if ($res && $res->RecordCount () > 0) {
//			$lang_ids = array ( ) ;
//			$lang_names = array ( ) ;
//			while ( ! $res->EOF ) {
//				array_push ( $lang_ids, $res->fields [ "ID" ] ) ;
//				if ($lang [ $res->fields [ "Name" ] ]) {
//					array_push ( $lang_names, $lang [ $res->fields [ "Name" ] ] ) ;
//				} else
//					array_push ( $lang_names, $res->fields [ "Description" ] ) ;
//				$res->MoveNext () ;
//			}
//			$this->smarty->assign ( 'lang_ids', $lang_ids ) ;
//			$this->smarty->assign ( 'lang_names', $lang_names ) ;
//		} else {
//			$this->smarty->assign ( 'lang_ids', array ( ) ) ;
//			$this->smarty->assign ( 'lang_names', array ( ) ) ;
//		}
	    
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
		
		/* design */
		$design_ids = array();
		$design_names = array();
		$sql = $this->db->prepare("SELECT ID, Name FROM ".DB_PREFIX."design WHERE LangID='".$this->user->edit_lang_id."'");
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
		    while (!$res->EOF){
		        $design_ids[] = $res->fields['ID'];
		        $design_names[] = $res->fields['Name'];
		        $res->MoveNext();
		    }
		}
		$this->smarty->assign('design_ids', $design_ids);
		$this->smarty->assign('design_names', $design_names);
	    
		/* Del */
		$Del_ids = array('no','yes');
	    $Del_names = array();
	    if (isset($this->lang[$this->getName()."_Del_no"])){
	      $Del_names[0] = $this->lang[$this->getName()."_Del_no"];
	    } else $Del_names[0] = $this->getName()."_Del_no";
	    if (isset($this->lang[$this->getName()."_Del_yes"])){
	      $Del_names[1] = $this->lang[$this->getName()."_Del_yes"];
	    } else $Del_names[1] = $this->getName()."_Del_yes";
	    $this->smarty->assign("Del_ids",$Del_ids);
	    $this->smarty->assign("Del_names",$Del_names);
		
		/* Module_default */
		$Module_default_ids = array('no','yes');
	    $Module_default_names = array();
	    if (isset($this->lang[$this->getName()."_Module_default_no"])){
	      $Module_default_names[0] = $this->lang[$this->getName()."_Module_default_no"];
	    } else $Module_default_names[0] = $this->getName()."_Module_default_no";
	    if (isset($this->lang[$this->getName()."_Module_default_yes"])){
	      $Module_default_names[1] = $this->lang[$this->getName()."_Module_default_yes"];
	    } else $Module_default_names[1] = $this->getName()."_Module_default_yes";
	    $this->smarty->assign("Module_default_ids",$Module_default_ids);
	    $this->smarty->assign("Module_default_names",$Module_default_names);
		
		
		if (!empty($id)){
			$sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."blocks WHERE ID='".$id."'");
			$res = $this->db->Execute($sql);
			if ($res && $res->RecordCount() > 0){
				
				$values = $res->getArray();
				$this->smarty->assign("items_arr",$values);
				
			} else $this->smarty->assign("items_arr",array());
		} else {
			$this->smarty->assign("items_arr",array(array("External"=>0)));
			$this->smarty->assign("after_checked","checked");
		}
	}
	
	function blocksmanager_form($form,$tab_id,$id=""){
		$objResponse = new xajaxResponse();
		$this->setTemplateVars();
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
		    $objResponse->addScriptCall("createNewTab","dhtmlgoodies_tabView1",$tab_title,$file,'');
		}
		return $objResponse->getXML();
	}

	
		
		
	function blocksmanager_add($data){
		$objResponse = new xajaxResponse();
		if ($this->checkRequiredFields($data)){
			$sql = $this->db->prepare("INSERT INTO ".DB_PREFIX."blocks (Name,Del,DesignID,Module,ModuleSpec,Module_default,LangID,GetAdd, MenuID) VALUES ('".$data["Name"]."','".$data["Del"]."','".$data["DesignID"]."','".$data["Module"]."','".$data["ModuleSpec"]."','".$data["Module_default"]."','".$this->user->edit_lang_id."', '".$data["GetAdd"]."', '".$data['MenuID']."')");
			if ($this->db->Execute($sql)){
				$msg = $this->lang[$this->getName()."_add_suc"];
				$objResponse->addScriptCall("xajax_".$this->getName()."_refresh",$data['tab_id']);
				$objResponse->addScriptCall("deleteTab",false,'parentActiveTabCount','dhtmlgoodies_tabView1');
			} else {
				$msg = $this->lang[$this->getName()."_add_err"];
			}
		} else {
      		$msg = $this->lang["requered_data_absent"]; 
    	}
		$objResponse->addAlert($msg);
		return $objResponse->getXML();
	}
	
	function blocksmanager_change($data){
		$error = false;
		$msg = "";
		
		if ($this->checkRequiredFields($data)){
			$sql = $this->db->prepare("UPDATE ".DB_PREFIX."blocks SET Name = '".$data["Name"]."', Del = '".$data["Del"]."', DesignID='".$data["DesignID"]."', Module='".$data["Module"]."', ModuleSpec='".$data["ModuleSpec"]."', Module_default='".$data["Module_default"]."', LangID='".$this->user->edit_lang_id."', GetAdd='".$data["GetAdd"]."', MenuID='".$data['MenuID']."' WHERE ID='".$data["ID"]."'");
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
			$objResponse->addScriptCall("xajax_".$this->getName()."_refresh",$data['tab_id']);
			$objResponse->addScriptCall("deleteTab",false,'parentActiveTabCount','dhtmlgoodies_tabView1');
		}
		return $objResponse->getXML();
	}
	
	function blocksmanager_delete($id){
	    $objResponse = new xajaxResponse();
		$sql = $this->db->prepare("DELETE FROM ".DB_PREFIX."blocks WHERE ID='".$id."'");
		if ($this->db->Execute($sql)){
		    $sql = $this->db->prepare("DELETE FROM ".DB_PREFIX."blocks_vars WHERE BlocksID='".$id."'");
		    $this->db->Execute($sql);
		    $objResponse->addScriptCall("xajax_".$this->getName()."_refresh",$this->tabID);
			$msg = $this->lang[$this->getName()."_delete_suc"];
		} else {
			$msg = $this->lang[$this->getName()."_delete_err"];
		}
		$objResponse->addAlert($msg);
		$objResponse->addScriptCall("xajax_".$this->getName()."_refresh",$this->tabID);
		return $objResponse->getXML();
	}
	
	function blocksmanager_refresh($tab_id){
		$objResponse = new xajaxResponse();
		$this->setClassVars();
		$this->setTemplateVars();		
		$objResponse->addScriptCall("showTab","dhtmlgoodies_tabView1",$tab_id);
		$objResponse->addAssign($this->visual_div_name,'innerHTML',$this->getData());
		$objResponse->addScriptCall("initTableWidget","myTable","100%","480","Array(".$this->sort_table_fields.")");
		return $objResponse->getXML();
	}
	
	
	function blocksmanager_show_design($lang_id){
		$options = '<select name="DesignID" id="DesignID">';
	    $options .= '<option value="0">'.$this->lang['select_default_name'].'</option>';
	    $sql = $this->db->prepare("SELECT ID, Name FROM ".DB_PREFIX."design WHERE LangID='".$this->user->edit_lang_id."'");
	    $res = $this->db->Execute($sql);
	    if ($res && $res->RecordCount() > 0){
	        while (!$res->EOF){
	            $options .= '<option value="'.$res->fields['ID'].'">'.$res->fields['Name'].'</option>';
	            $res->MoveNext();    
	        }
	    }
		$options .= '</select>';
	    $objResponse = new xajaxResponse();
		$objResponse->addAssign("DesignIDDiv","innerHTML", $options);
	    return $objResponse->getXML();
	}
	
	function blocksmanager_copyform($id){
	    $form = 'copy';
        $objResponse = new xajaxResponse();
		$this->setTemplateVars();
		
		$this->smarty->assign("ID",$id);
		
		if (check_rights($form)){
			
			$this->smarty->assign("form",$form);
			$this->smarty->assign("tab_prefix",$this->getName());
			$file = $this->smarty->fetch($this->tpl_module_path.'/'.$this->getName().'/copy.tpl',null,$this->language);
			$objResponse->addScriptCall("deleteTab",false,'parentActiveTabCount','dhtmlgoodies_tabView1');
			if (isset($this->lang["tab_".$this->getName()."_".$form])){
				$tab_title = $this->lang["tab_".$this->getName()."_".$form];
			} else $tab_title = "tab_".$this->getName()."_".$form;
		    $objResponse->addScriptCall("createNewTab","dhtmlgoodies_tabView1",$tab_title,$file,'');
		}
		return $objResponse->getXML();
	}
	
    function blocksmanager_copy($data){
		$error = false;
		$msg = "";
		
		
		if ($this->checkRequiredFields($data)){
			$sql = $this->db->prepare("INSERT INTO ".DB_PREFIX."blocks (Name,LangID,Del,DesignID,Module,ModuleSpec,Module_default,GetAdd) SELECT '".$data['Name']."' as Name, LangID,Del,DesignID,Module,ModuleSpec,Module_default,GetAdd FROM ".DB_PREFIX."blocks WHERE ID='".$data["ID"]."'");
			if ($this->db->Execute($sql)){
			    $blockID = $this->db->Insert_ID(DB_PREFIX."blocks");
			    $sql = $this->db->prepare("INSERT INTO ".DB_PREFIX."blocks_vars (BlocksID,Module,Params,BlockName,BlockOrder) SELECT '".$blockID."' as BlocksID,Module,Params,BlockName,BlockOrder FROM ".DB_PREFIX."blocks_vars WHERE BlocksID='".$data["ID"]."'");
			    $this->db->Execute($sql);
				$msg = $this->lang[$this->getName()."_copy_suc"];
			} else {
				$error = true;
				$msg = $this->lang[$this->getName()."_copy_err"];
			}
		} else {
			$error = true;
      		$msg = $this->lang["requered_data_absent"]; 
    	}

		$objResponse = new xajaxResponse();
		$objResponse->addAlert($msg);
		if (!$error){
			$objResponse->addScriptCall("xajax_".$this->getName()."_refresh",$this->tabID);
			$objResponse->addScriptCall("deleteTab",false,'parentActiveTabCount','dhtmlgoodies_tabView1');
		}
		return $objResponse->getXML();
	}
}
?>
