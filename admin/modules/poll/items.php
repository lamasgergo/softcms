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
		$this->addXajaxFunction($this->getName()."_showOrder");
				
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
		$cats = array();
		$sql = $this->db->prepare("SELECT * FROM ".POLL_PREFIX."category WHERE LangID='".$this->user->edit_lang_id."' ORDER BY ID ASC");
	    $res = $this->db->Execute($sql);
	    if ($res && $res->RecordCount() > 0){
	       while (!$res->EOF){
				$cats[] = $res->fields['ID'];    
				$res->MoveNext();
			}
	    } 
	
	    $sql = $this->db->prepare("SELECT * FROM ".POLL_PREFIX."item WHERE CategoryID IN ('".implode("','", $cats)."') ORDER BY CategoryID ASC, OrderNum ASC");
	    $res = $this->db->Execute($sql);
	    if ($res && $res->RecordCount() > 0){
	        $this->smarty->assign("items_arr", $res->getArray());
	    } else { 
	        $this->smarty->assign("items_arr", array());
	    }
	    return $this->smarty->fetch($this->tpl_path.'/table.tpl', null, $this->language);
	}	
	
	
	
    function formData($form,$id=""){
	    // BlocksID
	    $blocks_sql = "SELECT ID, Name FROM ".POLL_PREFIX."category WHERE LangID='".$this->user->edit_lang_id."'";
	    $this->getOptions($blocks_sql,array('ID','Name'), array('category_ids','category_names'));

		
		if (!empty($id)){
			$sql = $this->db->prepare("SELECT * FROM ".POLL_PREFIX."item WHERE ID='".$id."'");
			$res = $this->db->Execute($sql);
			if ($res && $res->RecordCount() > 0){
        		
				$values = $res->getArray();
				$this->smarty->assign("items_arr",$values);
				
				// OrderNum
				$order_sql = "SELECT OrderNum, Name FROM ".POLL_PREFIX."item WHERE CategoryID='".$values[0]['CategoryID']."' ORDER BY OrderNum ASC";
				$this->getOptions($order_sql,array('OrderNum','Name'), array('OrderNum_ids','OrderNum_names'));
				
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
			$orderNum = $this->changeItemsOrderNum($data["order"], $data["OrderNum"], $data["CategoryID"], $data["ID"]);
			$sql = $this->db->prepare("INSERT INTO ".POLL_PREFIX."item
				(
					Name,
					CategoryID,
					OrderNum
				) VALUES(
					'".$data["Name"]."',
					'".$data["CategoryID"]."',
					'".$orderNum."'
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
	
    function items_change($data){
		$error = false;
		$msg = "";
		
		$objResponse = new xajaxResponse();
		
		if ($this->checkRequiredFields($data)){
		    isset($data['Published']) ? $published = $data['Published'] : $published = 0;
			$orderNum = $this->changeItemsOrderNum($data["order"], $data["OrderNum"], $data["CategoryID"], $data["ID"]);
			$sql = $this->db->prepare("UPDATE ".POLL_PREFIX."item SET 
					CategoryID='".$data["CategoryID"]."',
					Name='".$data["Name"]."',
					OrderNum='".$orderNum."'
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
		$sql = $this->db->prepare("DELETE FROM ".POLL_PREFIX."item WHERE ID='".$id."'");
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
                $sql = $this->db->prepare("UPDATE " . POLL_PREFIX . "item SET Published='" . $value . "' WHERE ID='" . $id . "'");
                $res = $this->db->Execute($sql);
            }
        } else
            $objResponse->addAlert($lang["per_cant_publish"]);
        return $objResponse->getXML();
    }
    
	function changeItemsOrderNum($order, $orderNum, $CategoryID, $id=0){
		$symb = "+";
		$curOrderNum = 0;

		if ($order==""){
			return $orderNum;
		}
		
		if ($id!=0){
			// if CategoryId was changed remove from old category
			$sql = $this->db->prepare("SELECT CategoryID, OrderNum FROM ".POLL_PREFIX."item WHERE ID='".$id."'");
			$res = $this->db->Execute($sql);
			if ($res && $res->RecordCount() > 0){
				$curOrderNum = $res->fields['OrderNum'];
				if ($curOrderNum==$orderNum){
					return $orderNum;
				}
				if ($res->fields['CategoryID']!=$CategoryID){
					$sql = "UPDATE ".POLL_PREFIX."item SET OrderNum = OrderNum - 1 WHERE CategoryID='".$res->fields['CategoryID']."' AND OrderNum > '".$res->fields['OrderNum']."'" ;
				}
			}
			
			if ($order=="after"){
				$symb = '-';
				$sql_string = "UPDATE ".POLL_PREFIX."item SET OrderNum = OrderNum ".$symb." 1 WHERE CategoryID='".$CategoryID."'";
#				if ($curOrderNum!=0){
					$sql_string .= " AND OrderNum > ".$curOrderNum;
#				}
				$sql_string .= " AND OrderNum <= ".$orderNum;
			}
			if ($order=="before"){
				$sql_string = "UPDATE ".POLL_PREFIX."item SET OrderNum = OrderNum ".$symb." 1 WHERE CategoryID='".$CategoryID."'";
				if ($curOrderNum!=0){
					$sql_string .= " AND OrderNum < '".$curOrderNum."'";
				}
				$sql_string .= " AND OrderNum >= '".$orderNum."'";
			}
		} else {
			if ($order=="after"){
				$orderNum = $orderNum + 1;
			}
			$sql_string = "UPDATE ".POLL_PREFIX."item SET OrderNum = OrderNum ".$symb." 1 WHERE CategoryID='".$CategoryID."' AND OrderNum >= '".$orderNum."'";
		}
		$sql = $this->db->prepare($sql_string);
		$this->db->Execute($sql);
		
		return $orderNum;
	}
    
	function items_showOrder ($CategoryID){
		$options = '<select name="OrderNum" id="OrderNum">';
	    $options .= '<option value="0">'.$this->lang['select_default_name'].'</option>';
	    $objResponse = new xajaxResponse();
	    $sql = $this->db->prepare("SELECT OrderNum, Name FROM ".POLL_PREFIX."item WHERE CategoryID='".$CategoryID."' ORDER BY OrderNum ASC");
	    $res = $this->db->Execute($sql);
	    if ($res && $res->RecordCount() > 0){
    	    while (!$res->EOF){
                $options .= '<option value="'.$res->fields['OrderNum'].'">'.$res->fields['Name'].' ('.$res->fields['OrderNum'].')</option>';
                $res->MoveNext();
    	    }
	    }
	    $options .= '</select>';
	    $objResponse->addAssign('OrderNumDiv','innerHTML',$options);
	    return $objResponse->getXML();
	}
}
?>