<?php

class WidgetElement{
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

	/* ADODB object */
	var $db;

	/* xAjax object */
	var $xajax;

	/* array of xajax functions names*/
	var $xajax_functions;

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
	
	/* root path for templates*/
	var $tpl_path;
	/* root path for module templates*/
	var $tpl_module_path;
	
	/* ID of the class (tab ID) */
	var $counter = 0;
	var $tabID;
	
	/* Upload directory */
	var $uploadDirectory;
	/* Relative path to images dir */
	var $relativePath;
	
	/* user ID*/
	var $user;
	
	
	function WidgetElement($mod_name){
		global $smarty,$language,$lang,$xajax,$db,$user;
		$this->counter++;
		$this->user = $user;
		$this->visual_div_name = "widget_".$this->getName();
		$this->smarty = &$smarty;
		$this->xajax = &$xajax;
		//register common ajax functions
		$this->addXajaxFunction("show_form");
		$this->addXajaxFunction("delete_image");
		//set existing objects
		$this->db = &$db;
		$this->lang = $lang;
		$this->language = $language;
		//set common module name
		$this->mod_name = $mod_name;
		//set path to tab module templates
		$this->tpl_module_path = strtolower($this->mod_name);
		// set directory for image upload
		$this->uploadDirectory = uploadDirectory.'/gallery/';
		// set url to uploaded images
		$this->relativePath = uploadDirectoryURL;
		// set ajax functions
		$this->setAjaxVars();
	}
	
		
	// register ajax functions
	function setAjaxVars(){
		foreach ($this->xajax_functions as $func_name){
			$this->xajax->registerFunction(array($func_name,$this,$func_name));
		}
	}
	
	function addXajaxFunction($name){
		$this->xajax_functions[] = $name;	
	}
	
	
	function getFilter(){
		return "";
	}
	
	function refresh($tab_id=0){
		$objResponse = new xajaxResponse();
		$objResponse->addAlert($this->tab_id);
		$objResponse->addAssign($this->visual_div_name,'innerHTML',$this->getValue());
		$objResponse->addScriptCall("initTableWidget","myTable","100%","480","Array(".$this->sort_table_fields.")");
		$objResponse->addScriptCall("showTab",$tab_id);
		$objResponse->addAlert($tab_id);
		return $objResponse->getXML();
	}
	
	
	function checkRequiredFields($data){
		if (isset($data["RequiredFields"]) && !empty($data["RequiredFields"])){
			$data["RequiredFields"] = preg_replace("/\s+/", "", $data["RequiredFields"]);
			$fields = explode(",",$data["RequiredFields"]);
			if (is_array($fields)){
				if (count($fields) > 0){
					foreach ($fields as $field){
						/*
						$field = trim($field);
						if(!isset($data[$field])){
							return false;
						}
						*/
						if (is_array($data[$field])){
							if (!isset($data[$field][0])){
								return false;
							}
						} else {
							if (isset($data[$field])){
								if (is_numeric($data[$field]) && $data[$field]==0){
									return false;
								}
								if (is_string($data[$field]) && $data[$field]==''){
									return false;
								}
								/*
								if ($data[$field]=='' || $data[$field]==0){
									echo $field.' '.$data[$field];
									return false;
								}
								*/
							} else {
								print_r($data);
								echo $field.' '.$data[$field];
								return false;
							}
						}
					}
				}
			}
		}
		return true;
	}
	
	function addFilter($filter=array()){
    	if (count($filter) > 0 ){
      	$this->filter[] = $filter;
    	}
  	}
  
  	function getFilterSQL(){
    	$sql = "";
    	if (count($this->filter) > 0){
      		for ($i=0; $i < count ($this->filter); $i++){
        		$filter = $this->filter[$i];
        		if (!empty($filter[1])){
        			$sql .= $filter[0]."='".$filter[1]."'";
        		}
        		if ($i!=count($this->filter) && !empty($sql)) $sql .= " ";
      		}
    	}
    	return $sql;
 	 }

  	function getFilterValueByName($name){
    	if (count($this->filter) > 0){
      		for ($i=0; $i < count ($this->filter); $i++){
        		$filter = $this->filter[$i];
        		if ($filter[0]==$name) {
          			return $filter[1];
        		}
      		}
    	}
    	return 0;
  	}
  	
	function showImagePreview($id, $uploadDirURL='', $uploadDir=''){
		if (empty($uploadDirURL)) $uploadDirURL = $this->relativePath;
		if (empty($uploadDir)) $uploadDir = $this->uploadDirectory;
  		$items_arr = array();
  		$sql = $this->db->prepare("SELECT ID FROM ".DB_PREFIX."images_group WHERE ID='".$id."'");
  		$res = $this->db->Execute($sql);
  		if ($res && $res->RecordCount() > 0){
			$sql = $this->db->prepare("SELECT ID,Name,Image,ImageResize FROM ".DB_PREFIX."images WHERE GroupID='".$res->fields["ID"]."'");
			$res = $this->db->Execute($sql);
			if ($res && $res->RecordCount() > 0){
				$items_arr = $res->getArray();
			}
  		}
  		$this->smarty->assign("image_path",$uploadDirURL);
  		$this->smarty->assign("uploadDir",$uploadDir);
  		$this->smarty->assign("images_arr",$items_arr);
  		return $this->smarty->fetch("images/preview.tpl",null,$this->language);
	}
	
	function delete_image($id, $uploadDir=''){
		if (empty($uploadDir)) $uploadDir = $this->uploadDirectory."/";
  		$objResponse = new xajaxResponse();
  		$sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."images WHERE ID='".$id."'");
  		$res = $this->db->execute($sql);
  		if ($res && $res->RecordCount() > 0){
    		if (file_exists($uploadDir.$res->fields["ImageResize"])){
      			@unlink($uploadDir.$res->fields["ImageResize"]);
    		}
    		if (file_exists($uploadDir.$res->fields["Image"])){
      			@unlink($uploadDir.$res->fields["Image"]);
    		}
    		if (!$this->db->Execute("DELETE FROM ".DB_PREFIX."images WHERE ID='".$id."'")){
      			$objResponse->addAlert($this->lang["images_deleted_err"]);
    		} else {
      			$objResponse->addScript("document.getElementById('".$res->fields["Name"]."').innerHTML=''");
      			$objResponse->addAlert($this->lang["images_deleted_suc"]);
    		}
    
  		}
  		return $objResponse->getXML();		
	}
	
	// $id bs_images_group
	function addUploadedFiles($id=0, $uploadDir=''){
		if (empty($uploadDir)) $uploadDir = $this->uploadDirectory."/";
		if (empty($id)){
			$sql = $this->db->prepare("INSERT INTO ".DB_PREFIX."images_group(Created) VALUES (NOW())");	
			if ($this->db->Execute($sql)){
				$id = $this->db->Insert_ID(DB_PREFIX."images_group","ID");
			}
		} 
		if ($id!=false && $id!=0){
	    	$sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."tmp_images WHERE UserID='".$this->user->id."' ORDER BY ID ASC");
	    	$res = $this->db->execute($sql);
	    	if ($res && $res->RecordCount() > 0){
	        	while (!$res->EOF){
			        copy(tmpuploadDirectory.$res->fields["Image"],$uploadDir.$res->fields["Image"]);
			        chmod($uploadDir.$res->fields["Image"],0777);
			        copy(tmpuploadDirectory.$res->fields["ImageResize"],$uploadDir.$res->fields["ImageResize"]);
			        chmod($uploadDir.$res->fields["ImageResize"],0777);
		           	$insql =$this->db->prepare("INSERT INTO ".DB_PREFIX."images(GroupID,Name,Image,ImageResize) VALUES ('".$id."','".$res->fields["Name"]."','".$res->fields["Image"]."','".$res->fields["ImageResize"]."')");
			       	if( $this->db->execute($insql)){
				       	unlink(tmpuploadDirectory.$res->fields["Image"]);
				       	unlink(tmpuploadDirectory.$res->fields["ImageResize"]);
				       	$this->db->execute("DELETE FROM ".DB_PREFIX."tmp_images WHERE ID='".$res->fields["ID"]."'");
			       	}
			       	$res->MoveNext();
	        	}
	    	}
		}
		return $id;
	}
	
	function deleteImagesGroup($groupID, $uploadDir=''){
		if (empty($uploadDir)) $uploadDir = $this->uploadDirectory."/";
		$sql = "SELECT ID FROM ".DB_PREFIX."images WHERE GroupID='".$groupID."'";
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			while (!$res->EOF){
				$this->delete_image($res->fields["ID"], $uploadDir);
				$res->MoveNext();	
			}
		}
		$sql = "DELETE FROM ".DB_PREFIX."images_group WHERE ID='".$groupID."'";
		$res = $this->db->Execute($sql);
	}
	
	function getOptions($sql_str, $sql_fields=array(), $assign=array()){
	    $ids = array();
		$names = array();
	    if (!empty($sql_str) && count($assign)!=0 && count($sql_fields)!=0){
    		$sql = $this->db->prepare($sql_str); 
    		$res = $this->db->Execute($sql);
    		if ($res && $res->RecordCount() > 0){
    			while (!$res->EOF){
    				$ids[] = $res->fields[$sql_fields[0]];
    				$names[] = $res->fields[$sql_fields[1]];
    				$res->MoveNext();
    			}
    		}
	    }
	    $this->smarty->assign($assign[0],$ids);
    	$this->smarty->assign($assign[1],$names);
	}
}
?>
