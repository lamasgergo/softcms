<?php
define("menu2UploadDirectory", $_SERVER['DOCUMENT_ROOT']."/files/left/");
define("menu2UploadDirectoryURL", SITE_URL."/files/left/");

class MenuTree extends TabElement{

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
	
	function MenuTree($mod_name,$tabID){
		$this->name=__CLASS__;
		$this->addXajaxFunction($this->getName()."_change");
		$this->addXajaxFunction($this->getName()."_add");
		$this->addXajaxFunction($this->getName()."_delete");
		$this->addXajaxFunction($this->getName()."_refresh");
		$this->addXajaxFunction($this->getName()."_form");
		$this->addXajaxFunction($this->getName()."_show_menu_ordernum");
		
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
	}
	
	function getTabContent(){
		return $this->getValue();	
	}
	
	
	function getTreeValues($parent_id=0, $ret=array(), $depth=0){
		$depth++;
		$sql = "SELECT * FROM ".DB_PREFIX."menutree WHERE ParentID='".$parent_id."' AND LangID='".$this->user->edit_lang_id."' ORDER BY OrderNum";
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			while (!$res->EOF){
				$depth_str = '';
				for ($i=0; $i<$depth; $i++) $depth_str .= '-';
				$ret[] = array(
							'ID'   		=> $res->fields["ID"],
							'Name' 		=> $depth_str.$res->fields["Name"],
							'Link' 		=> $res->fields["Link"],
							'LinkAlias'	=> $res->fields["LinkAlias"],
							'OrderNum' 	=> $res->fields["OrderNum"],
							'Created' 	=> $res->fields["Created"]
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
		$sql = "SELECT ID, Name FROM ".DB_PREFIX."menutree WHERE ParentID='".$parent_id."' AND LangID='".$this->user->edit_lang_id."' ORDER BY OrderNum";
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			while (!$res->EOF){
				$depth_str = '';
				for ($i=0; $i<$depth; $i++) $depth_str .= '-';
				$ret[] = array(
							'id'   => $res->fields["ID"],
							'name' => $depth_str.$res->fields["Name"]
						);
				
				$ret = MenuTree::getTreeList($res->fields["ID"], $ret, $depth);
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
		$this->smarty->assign("parent_ids",$parent_ids);
		$this->smarty->assign("parent_names",$parent_names);
		
		// ParentID

		$order_ids = array();
		$order_names = array();
		
		$sql = $this->db->prepare("SELECT OrderNum, Name FROM ".DB_PREFIX."menutree WHERE ParentID='0' AND LangID='".$this->user->edit_lang_id."' ORDER BY OrderNum ASC"); 
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			while (!$res->EOF){
				$order_ids[] = $res->fields["OrderNum"];
				$order_names[] = $res->fields["Name"];
				$res->MoveNext();
			}
		}
		
		$this->smarty->assign("order_ids",$order_ids);
		$this->smarty->assign("order_names",$order_names);
		
		
		 // Exists 
	    $External_ids = array(0,1);
	    $External_names = array();
	    if (isset($this->lang[$this->getName()."_External_no"])){
	      $External_names[0] = $this->lang[$this->getName()."_External_no"];
	    } else $External_names[0] = $this->getName()."_External_no";
	    if (isset($this->lang[$this->getName()."_External_yes"])){
	      $External_names[1] = $this->lang[$this->getName()."_External_yes"];
	    } else $External_names[1] = $this->getName()."_External_yes";
	    $this->smarty->assign("External_ids",$External_ids);
	    $this->smarty->assign("External_names",$External_names);
		
		if (!empty($id)){
			$sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."menutree WHERE ID='".$id."'");
			$res = $this->db->Execute($sql);
			if ($res && $res->RecordCount() > 0){
				$values = $res->getArray();
				
				// images
          		$this->smarty->assign("uploaded_files",$this->showImagePreviewFromDir(menuUploadDirectoryURL, menuUploadDirectory, $values[0]['Image']));
				
				// OrderNum
			    $OrderNum_ids = array();
			    $OrderNum_names = array();
				$sql = $this->db->prepare("SELECT Name,OrderNum FROM ".DB_PREFIX."menutree WHERE ParentID='".$values[0]["ParentID"]."' AND LangID='".$this->user->edit_lang_id."' ORDER BY OrderNum ASC");
				$res = $this->db->Execute($sql);
				if ($res && $res->RecordCount() > 0){
					while (!$res->EOF){
						$OrderNum_ids[] = $res->fields["OrderNum"];
						$OrderNum_names[] = $res->fields["Name"];
						$res->MoveNext();
					}
				}
				$this->smarty->assign("order_ids",$OrderNum_ids);
				$this->smarty->assign("order_names",$OrderNum_names);
				
				$this->smarty->assign("items_arr",$values);
				$this->smarty->assign("after_checked","");
				
			} else $this->smarty->assign("items_arr",array());
		} else {
			$this->smarty->assign("uploaded_files",$this->showImagePreviewFromDir(menuUploadDirectoryURL, menuUploadDirectory, $values[0]['Image']));
			$this->smarty->assign("items_arr",array(array("External"=>0)));
			$this->smarty->assign("after_checked","checked");
		}
	}
	
	function showImagePreviewFromDir($uploadDirURL='', $uploadDir='', $selected=''){
		if (empty($uploadDirURL)) $uploadDirURL = $this->relativePath;
		if (empty($uploadDir)) $uploadDir = $this->uploadDirectory;
  		$items_arr = array();
  		
  		$d = dir($uploadDir);
  		
  		while (false !== ($entry = $d->read())) {
   			if (!is_dir($entry) && $entry!='.' && $entry !='..'){
   				$items_arr[] = $entry;	
   			}
		}
		
		$d->close();
		
  		
  		$this->smarty->assign("selected",$selected);
  		$this->smarty->assign("image_path",$uploadDirURL);
  		$this->smarty->assign("uploadDir",$uploadDir);
  		$this->smarty->assign("images_arr",$items_arr);
  		return $this->smarty->fetch("menu_tree/preview_files.tpl",null,$this->language);
	}
	
	function showImagePreviewFromDir2($uploadDirURL='', $uploadDir='', $selected=''){
		if (empty($uploadDirURL)) $uploadDirURL = $this->relativePath;
		if (empty($uploadDir)) $uploadDir = $this->uploadDirectory;
  		$items_arr = array();
  		
  		$d = dir($uploadDir);
  		
  		while (false !== ($entry = $d->read())) {
   			if (!is_dir($entry) && $entry!='.' && $entry !='..'){
   				$items_arr[] = $entry;	
   			}
		}
		
		$d->close();
		
  		
  		$this->smarty->assign("selected2",$selected);
  		$this->smarty->assign("image_path",$uploadDirURL);
  		$this->smarty->assign("uploadDir",$uploadDir);
  		$this->smarty->assign("images_arr",$items_arr);
  		return $this->smarty->fetch("menu_tree/preview_files2.tpl",null,$this->language);
	}
	
	function menutree_form($form,$id=""){
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

	
		
	function changeItemsOrderNum($order, $orderNum, $parentID=0, $id=0){
		$symb = "+";
		$curOrderNum = 0;

		if ($order==""){
			return $orderNum;
		}
		
		if ($id!=0){
			$sql = $this->db->prepare("SELECT OrderNum, ParentID FROM ".DB_PREFIX."menutree WHERE id='".$id."' AND LangID='".$this->user->edit_lang_id."'");
			$res = $this->db->Execute($sql);
			if ($res && $res->RecordCount() > 0){
				$curOrderNum = $res->fields["OrderNum"];
				$curParentID = $res->fields["ParentID"];
				if ($curOrderNum < $orderNum){
					$symb = "-";	
				}
				if ($curOrderNum == $orderNum){
					return $orderNum;
				}
			}
			
			if ($curParentID!=$parentID){
				$sql = $this->db->prepare("UPDATE ".DB_PREFIX."menutree SET OrderNum = OrderNum - 1 WHERE ParentID='".$curParentID."' AND OrderNum >= '".$curOrderNum."' AND LangID='".$this->user->edit_lang_id."'");
				$this->db->Execute($sql);
				$curOrderNum = 0;
			}
			
			if ($order=="after"){
				$sql_string = "UPDATE ".DB_PREFIX."menutree SET OrderNum = OrderNum ".$symb." 1 WHERE ParentID='".$parentID."' AND LangID='".$this->user->edit_lang_id."'";
				if ($curOrderNum!=0){
					$sql_string .= " AND OrderNum > ".$curOrderNum;
				}
				$sql_string .= " AND OrderNum <= ".$orderNum;
			}
			if ($order=="before"){
				$sql_string = "UPDATE ".DB_PREFIX."menutree SET OrderNum = OrderNum ".$symb." 1 WHERE ParentID='".$parentID."' AND LangID='".$this->user->edit_lang_id."'";
				if ($curOrderNum!=0){
					$sql_string .= " AND OrderNum < '".$curOrderNum."'";
				}
				$sql_string .= " AND OrderNum >= '".$orderNum."'";
			}
		} else {
			if ($order=="after"){
				$orderNum = $orderNum + 1;
			}
			$sql_string = "UPDATE ".DB_PREFIX."menutree SET OrderNum = OrderNum ".$symb." 1 WHERE ParentID='".$parentID."' AND OrderNum >= ".$orderNum." AND LangID='".$this->user->edit_lang_id."'";
		}
		
		$sql = $this->db->prepare($sql_string);
		$this->db->Execute($sql);
		
		return $orderNum;
	}
	
	
	function menutree_add($data){
		$objResponse = new xajaxResponse();
		if ($this->checkRequiredFields($data)){
			$orderNum = $this->changeItemsOrderNum($data["order"], $data["OrderNum"], $data["ParentID"]);
			
			if (!isset($data["Published"])) $data["Published"] = 0;
			
			$sql = $this->db->prepare("INSERT INTO ".DB_PREFIX."menutree (Name,Link,LinkAlias,ParentID,OrderNum,External,Created,LangID,Published, Image) VALUES ('".$data["Name"]."','".$data["Link"]."','".$data["LinkAlias"]."','".$data["ParentID"]."','".$orderNum."','".$data["External"][0]."',NOW(),'".$this->user->edit_lang_id."','".$data['Published']."', '".$data['Image']."')");
			if ($this->db->Execute($sql)){
				
				$this->moveUploadedFiles(menuUploadDirectory);
				
				$msg = $this->lang[$this->getName()."_add_suc"];
				$objResponse->addScriptCall("xajax_".$this->getName()."_refresh",$this->tabID);
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
	
	function menutree_change($data){
		$error = false;
		$msg = "";
		
		if ($this->checkRequiredFields($data)){
			$orderNum = $this->changeItemsOrderNum($data["order"], $data["OrderNum"], $data["ParentID"], $data["ID"]);

			if (!isset($data["Published"])) $data["Published"] = 0;
			
			$sql = $this->db->prepare("UPDATE ".DB_PREFIX."menutree SET Name = '".$data["Name"]."', Link = '".$data["Link"]."', LinkAlias = '".$data["LinkAlias"]."', ParentID='".$data["ParentID"]."', OrderNum='".$orderNum."', External='".$data["External"][0]."', Published='".$data["Published"]."', Image='".$data['Image']."' WHERE ID='".$data["ID"]."'");
			
			if ($this->db->Execute($sql)){
				
				$this->moveUploadedFiles(menuUploadDirectory);
				
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
			$objResponse->addScriptCall("xajax_".$this->getName()."_refresh",$this->tabID);
			$objResponse->addScriptCall("deleteTab",false,'parentActiveTabCount','dhtmlgoodies_tabView1');
		}
		return $objResponse->getXML();
	}
	
	function menutree_delete($id){
		$sql = $this->db->prepare("SELECT ID, ParentID, OrderNum FROM ".DB_PREFIX."menutree WHERE ID='".$id."'");
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			$this->db->Execute("UPDATE ".DB_PREFIX."menutree SET OrderNum = OrderNum - 1 WHERE ParentID='".$res->fields["ParentID"]."' AND OrderNum >= '".$res->fields["OrderNum"]."' AND LangID='".$this->user->edit_lang_id."'");	
		}
		$sql = $this->db->prepare("DELETE FROM ".DB_PREFIX."menutree WHERE ID='".$id."'");
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
	
	function menutree_refresh($tab_id){
		$objResponse = new xajaxResponse();
		$this->setClassVars();
		$this->setTemplateVars();		
		$objResponse->addScriptCall("showTab","dhtmlgoodies_tabView1",$tab_id);
		$objResponse->addAssign($this->visual_div_name,'innerHTML',$this->getValue());
		$objResponse->addScriptCall("initTableWidget","myTable","100%","480","Array(".$this->sort_table_fields.")");
		return $objResponse->getXML();
	}
	
	function menutree_show_menu_ordernum($id){
		$objResponse = new xajaxResponse();
		
		isset($this->lang["select_default_name"]) ? $def_value = $this->lang["select_default_name"] : "select_default_name";
		
		$values = '<select name="OrderNum" id="OrderNum">
        				<option value="0">'.$def_value.'</option>';
		$sql = $this->db->prepare("SELECT Name,OrderNum FROM ".DB_PREFIX."menutree WHERE ParentID='".$id."' ORDER BY OrderNum ASC");
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			while (!$res->EOF){
				$values .= '<option value="'.$res->fields["OrderNum"].'">'.$res->fields["Name"].'</option>';
				$res->MoveNext();
			}
		}
		$values .= '</select>';
		$objResponse->addAssign("ordernum_div","innerHTML",$values);
		return $objResponse->getXML();
	}
	
}
?>
