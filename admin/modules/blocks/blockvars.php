<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/admin/helpers/blocks.php';

class BlockVars extends TabElement{

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
	
	function BlockVars($moduleName,$tabID){
		$this->name=__CLASS__;
		$this->addXajaxFunction($this->getName()."_change");
		$this->addXajaxFunction($this->getName()."_add");
		$this->addXajaxFunction($this->getName()."_delete");
		$this->addXajaxFunction($this->getName()."_refresh");
		$this->addXajaxFunction($this->getName()."_form");
		$this->addXajaxFunction($this->getName()."_showBlockNames");
		$this->addXajaxFunction($this->getName()."_showBlocksOrder");
		
		parent::TabElement($mod_name);
		
		$this->xajax->registerFunction(array('BlocksModuleHelper',BlocksHelper,'BlocksModuleHelper'));
		$this->xajax->registerFunction(array('ModuleHelperAddParam',BlocksHelper,'ModuleHelperAddParam'));
		
		$this->setClassVars();
		
		//set current tab ID
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
	function getValue($block_id=0){
		$blocks = array();
		$sql = $this->db->prepare("SELECT ID FROM ".DB_PREFIX."blocks WHERE langID='".$this->user->edit_lang_id."'");
	    $res = $this->db->Execute($sql);
	    if ($res && $res->RecordCount() > 0){
			while (!$res->EOF){
				$blocks[] = $res->fields['ID'];    
				$res->MoveNext();
			}
	    }
	
	    $items = array();
	    $conditions = array();
		$conditions[] = "BlocksID IN ('".implode("','", $blocks)."')";
	    if ($block_id!=0) $conditions[] = "BlocksID='".$block_id."'";
	    $sql_str = "SELECT * FROM ".DB_PREFIX."blocks_vars ";
	    if (count($conditions) > 0) $sql_str .= " WHERE ". join(" ", $conditions);
	    $sql_str .= ' ORDER BY BlocksID, BlockName,BlockOrder';
	    $sql = $this->db->prepare($sql_str);
	    $res = $this->db->Execute($sql);
	    if ($res && $res->RecordCount() > 0){
	        $items = $res->getArray();    
	    }
	    $this->smarty->assign("items_arr",$items);
	    return $this->smarty->fetch($this->tpl_path.'/table.tpl',null,$this->language);
	}	
	
	
	
		
	function formData($form,$id=""){
	    $values = array();
	    
	    // BlocksID
	    $blocks_sql = "SELECT ID, Name FROM ".DB_PREFIX."blocks WHERE LangID='".$this->user->edit_lang_id."'";
	    $this->getOptions($blocks_sql,array('ID','Name'), array('block_ids','block_names'));
	    
				
		if (!empty($id)){
			$sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."blocks_vars WHERE ID='".$id."'");
			$res = $this->db->Execute($sql);
			if ($res && $res->RecordCount() > 0){
				
				$values = $res->getArray();
				
				
				//BlockNames
            	$blockname_names = array();
        	    $block_names = $this->getBlockNames($values[0]['BlocksID']);
        	    if (count($block_names)> 0){
        	        foreach ($block_names as $name){
                        $blockname_names[] = $name;
                    }
        	    }
        	    $this->smarty->assign('blockname_ids',$blockname_names);
            	$this->smarty->assign('blockname_names',$blockname_names);
				
            	// OrderID
        		$blockorder_sql = "SELECT BlockOrder, CONCAT(BlockName,' (',BlockOrder,' ',Params,')') AS BlockName FROM ".DB_PREFIX."blocks_vars WHERE BlockName='".$values[0]['BlockName']."' AND BlocksID='".$values[0]['BlocksID']."' ORDER BY BlockOrder ASC";
        	    $this->getOptions($blockorder_sql,array('BlockOrder','BlockName'), array('blockorder_ids','blockorder_names'));
            	
			}
		}
		$this->smarty->assign('modules', BlocksHelper::getModulesListOptions($values));
		
		$this->smarty->assign("items_arr",$values);
	}
	
	function blockvars_form($form,$tab_id, $id=""){
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

	
		
		
	function blockvars_add($data){
		$objResponse = new xajaxResponse();
		if ($this->checkRequiredFields($data)){
		    $orderNum = $this->changeItemsOrderNum($data["order"], $data["BlockOrder"], $data["BlocksID"], $data['BlockName']);
			$sql = $this->db->prepare("INSERT INTO ".DB_PREFIX."blocks_vars (BlocksID,Module,Params,BlockName,BlockOrder) VALUES ('".$data["BlocksID"]."','".$data["Module"]."','".mysql_escape_string($data["Params"])."','".$data["BlockName"]."','".$orderNum."')");
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
	
	function blockvars_change($data){
		$error = false;
		$msg = "";
		
		if ($this->checkRequiredFields($data)){
		    $orderNum = $this->changeItemsOrderNum($data["order"], $data["BlockOrder"], $data["BlocksID"], $data['BlockName'], $data["ID"]);
			$sql = $this->db->prepare("UPDATE ".DB_PREFIX."blocks_vars SET BlocksID = '".$data["BlocksID"]."', Module = '".$data["Module"]."', Params='".mysql_escape_string($data["Params"])."', BlockName='".$data["BlockName"]."', BlockOrder='".$orderNum."' WHERE ID='".$data["ID"]."'");
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
	
	function blockvars_delete($id){
	    $sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."blocks_vars WHERE ID='".$id."'");
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			$this->db->Execute("UPDATE ".DB_PREFIX."blocks_vars SET BlockOrder = BlockOrder - 1 WHERE BlocksID='".$res->fields["BlocksID"]."' AND BlockName='".$res->fields["BlockName"]."' AND BlockOrder >= '".$res->fields["BlockOrder"]."'");	
		}
		$sql = $this->db->prepare("DELETE FROM ".DB_PREFIX."blocks_vars WHERE ID='".$id."'");
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
	
	function blockvars_refresh($tab_id, $block_id=0){
		$objResponse = new xajaxResponse();
		$this->setClassVars();
		$this->setTemplateVars();		
		$objResponse->addScriptCall("showTab","dhtmlgoodies_tabView1",$tab_id);
		$objResponse->addAssign($this->visual_div_name,'innerHTML',$this->getValue($block_id));
		$objResponse->addScriptCall("initTableWidget","myTable","100%","480","Array(".$this->sort_table_fields.")");
		return $objResponse->getXML();
	}
	
	function blockvars_showBlockNames($blocksID){
	    $options = '<select name="BlockName" id="BlockName" onChange="xajax_blockvars_showBlocksOrder(document.getElementById(\'BlocksID\').options[document.getElementById(\'BlocksID\').selectedIndex].value, this.value);">';
	    $options .= '<option value="">'.$this->lang['select_default_name'].'</option>';
	    $objResponse = new xajaxResponse();
	    $block_names = $this->getBlockNames($blocksID);
	    if (count($block_names)> 0){
	        foreach ($block_names as $name){
                $options .= '<option value="'.$name.'">'.$name.'</option>';
            }
	    }
	    $options .= '</select>';
	    $objResponse->addAssign('BlockNameDiv','innerHTML',$options);
	    return $objResponse->getXML();
	}
	
	function getBlockNames($blocksID){
	    $block_names = array();
	    $sql = $this->db->prepare("SELECT d.Name as Name, d.Tpl as Tpl FROM ".DB_PREFIX."blocks as b LEFT JOIN ".DB_PREFIX."design as d ON (d.ID=b.DesignID) WHERE b.ID='".$blocksID."'");
	    $res = $this->db->Execute($sql);
	    if ($res && $res->RecordCount() > 0){
	        $tpl = TEMPLATES.'/design/'.$res->fields['Name'].'/'.$res->fields['Tpl'];
    	    if (file_exists($tpl)){
                $fh = fopen($tpl, 'rb');
            	$tpl_source = fread($fh, filesize($tpl));
            	fclose($fh);
            	    
            	$block_names = array();
            	
                preg_match_all("/\{[$]{1}([A-Z\_\-]+)\}/su",$tpl_source,$vars);
            		if (count($vars[1]) > 0){
            			for ($i=0;$i<count($vars[1]);$i++) {
            				if ($vars[1][$i]){
            					$block_names[] = $vars[1][$i];
            				}
            			}
            		}
            	array_unique($block_names);
            }
	    }   
	    return $block_names; 
	}
	
	function blockvars_showBlocksOrder($BlocksID,$blockName){
	    $options = '<select name="BlockOrder" id="BlockOrder">';
	    $options .= '<option value="0">'.$this->lang['select_default_name'].'</option>';
	    $objResponse = new xajaxResponse();
	    $sql = $this->db->prepare("SELECT BlockOrder, BlockName, Params FROM ".DB_PREFIX."blocks_vars WHERE BlocksID='".$BlocksID."' AND BlockName='".$blockName."' ORDER BY BlockOrder ASC");
	    $res = $this->db->Execute($sql);
	    if ($res && $res->RecordCount() > 0){
    	    while (!$res->EOF){
                $options .= '<option value="'.$res->fields['BlockOrder'].'">'.$res->fields['BlockName'].' ('.$res->fields['BlockOrder'].' '.$res->fields['Params'].')</option>';
                $res->MoveNext();
    	    }
	    }
	    $options .= '</select>';
	    $objResponse->addAssign('BlockOrderDiv','innerHTML',$options);
	    return $objResponse->getXML();
	}
	
    function changeItemsOrderNum($order, $orderNum, $BlocksID, $blockName, $id=0){
		$symb = "+";
		$curOrderNum = 0;

		if ($order==""){
			return $orderNum;
		}
		
		if ($id!=0){
			$sql = $this->db->prepare("SELECT BlockOrder, BlockName FROM ".DB_PREFIX."blocks_vars WHERE ID='".$id."' AND BlockName='".$blockName."' AND BlocksID='".$BlocksID."'");
			$res = $this->db->Execute($sql);
			if ($res && $res->RecordCount() > 0){
				$curOrderNum = $res->fields["BlockOrder"];
				$curBlockName = $res->fields["BlockName"];
				if ($curOrderNum < $orderNum){
					$symb = "-";	
				}
				if ($curOrderNum == $orderNum){
					return $orderNum;
				}
			}
			
		    if ($curBlockName!=$blockName){
				$sql = $this->db->prepare("UPDATE ".DB_PREFIX."blocks_vars SET BlockOrder = BlockOrder - 1 WHERE BlockName='".$curBlockName."'AND BlocksID='".$BlocksID."' AND BlockOrder >= '".$curOrderNum."'");
				$this->db->Execute($sql);
				$curOrderNum = 0;
			}
			
			if ($order=="after"){
				$sql_string = "UPDATE ".DB_PREFIX."blocks_vars SET BlockOrder = BlockOrder ".$symb." 1 WHERE BlockName='".$blockName."' AND BlocksID='".$BlocksID."'";
#				if ($curOrderNum!=0){
					$sql_string .= " AND BlockOrder > ".$curOrderNum;
#				}
				$sql_string .= " AND BlockOrder <= ".$orderNum;
			}
			if ($order=="before"){
				$sql_string = "UPDATE ".DB_PREFIX."blocks_vars SET BlockOrder = BlockOrder ".$symb." 1 WHERE BlockName='".$blockName."' AND BlocksID='".$BlocksID."'";
				if ($curOrderNum!=0){
					$sql_string .= " AND BlockOrder < '".$curOrderNum."'";
				}
				$sql_string .= " AND BlockOrder >= '".$orderNum."'";
			}
		} else {
			if ($order=="after"){
				$orderNum = $orderNum + 1;
			}
			$sql_string = "UPDATE ".DB_PREFIX."blocks_vars SET BlockOrder = BlockOrder ".$symb." 1 WHERE BlockName='".$blockName."' AND BlocksID='".$BlocksID."' AND BlockOrder >= '".$orderNum."'";
		}
		$sql = $this->db->prepare($sql_string);
		$this->db->Execute($sql);
		
		return $orderNum;
	}
    
}
?>
