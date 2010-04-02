<?php
class ITabElement{
    function getValue(){}
    function formData(){}
    function getName(){}
}

class TabElement implements ITabElement{
	/* Name of a Tab Element */
	private $name;

	/* Body of a Tab Element */
	private $value;

	/* Action menu for Tab Element */
	private $menu;

	/* Data Filter for Tab Element */
	private $filter;

	/* Name of a DIV where Tab Element will parsed */
	private $visual_div_name;

	/* ADODB object */
	protected $db;

	/* Smarty object */
	protected $smarty;

	/* Lang array with localization privates */
	private $locale;

	/* private with lang ID for smarty templates engine */
	protected $language;

	/* Main module name */
	protected $mod_name;

	/* JS sortable params:
	 * false 	: don't sort
	 * 'S'		: string sorting
	 * 'N'		: numeric sorting
	 * 
	 * example: false,'S','N',false,'S','S'
	*/
	private $sort_table_fields;
	
	/* root path for templates*/
	private $tpl_path;
	/* root path for module templates*/
	private $tpl_module_path;
	
	/* ID of the class (tab ID) */
	private $counter = 0;
	private $tabID;
	
	/* Upload directory */
	private $uploadDirectory;
	/* Relative path to images dir */
	private $relativePath;
	
	/* user ID */
	private $user;

    /* data type*/
    private $type;

    private $fields = array();

    private $requiredFields = array();

    private $table;

	
	function __construct($mod_name){
		$this->counter++;

        $this->visual_div_name = "visual_".$this->getName();

        $obReg = ObjectRegistry::getInstance();
		$this->user = $obReg->get('user');
		$this->smarty = $obReg->get('smarty');
		$this->db = $obReg->get('db');
		
		$this->locale = $obReg->get('locale');
		$this->language = $obReg->get('language');

        //set common module name
		$this->mod_name = $mod_name;
		//set path to tab module templates
		$this->tpl_module_path = strtolower($this->mod_name);
		// set directory for image upload
		$this->uploadDirectory = uploadDirectory.'/gallery/';
		// set url to uploaded images
		$this->relativePath = uploadDirectoryURL;

	}

    function getName() {
        return strtolower(__CLASS__);
    }
		
	function getMenu(){
		$menu_items = array('add','change','delete');
		foreach ($menu_items as $item){
            $this->smarty->assign("menu_".strtolower($this->name)."_".$item, $this->locale->get("menu_".strtolower($this->name)."_".$item));
		}
		return $this->smarty->fetch($this->tpl_path.'/menu/menu.tpl',null,$this->language);
	}
	
	function getFilter(){
		return "";
	}
	
//	function refresh($tab_id=0){
//		$objResponse = new xajaxResponse();
//		$objResponse->addAlert($this->tab_id);
//		$objResponse->addAssign($this->visual_div_name,'innerHTML',$this->getValue());
//		$objResponse->addScriptCall("initTableWidget","myTable","100%","480","Array(".$this->sort_table_fields.")");
//		$objResponse->addScriptCall("showTab",$tab_id);
//		$objResponse->addAlert($tab_id);
//		return $objResponse->getXML();
//	}
	
	
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

	function showImagePreviewFromDir($uploadDirURL='', $uploadDir=''){
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
		
  		
  		$this->smarty->assign("image_path",$uploadDirURL);
  		$this->smarty->assign("uploadDir",$uploadDir);
  		$this->smarty->assign("images_arr",$items_arr);
  		return $this->smarty->fetch("images/preview_files.tpl",null,$this->language);
	}
	
//	function delete_image($id, $uploadDir=''){
//		if (empty($uploadDir)) $uploadDir = $this->uploadDirectory."/";
//  		$objResponse = new xajaxResponse();
//  		$sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."images WHERE ID='".$id."'");
//  		$res = $this->db->execute($sql);
//  		if ($res && $res->RecordCount() > 0){
//    		if (file_exists($uploadDir.$res->fields["ImageResize"])){
//      			@unlink($uploadDir.$res->fields["ImageResize"]);
//    		}
//    		if (file_exists($uploadDir.$res->fields["Image"])){
//      			@unlink($uploadDir.$res->fields["Image"]);
//    		}
//    		if (!$this->db->Execute("DELETE FROM ".DB_PREFIX."images WHERE ID='".$id."'")){
//      			$objResponse->addAlert($this->locale["images_deleted_err"]);
//    		} else {
//      			$objResponse->addScript("document.getElementById('".$res->fields["Name"]."').innerHTML=''");
//      			$objResponse->addAlert($this->locale["images_deleted_suc"]);
//    		}
//
//  		}
//  		return $objResponse->getXML();
//	}
//
//	function delete_image_direct($file='', $uploadDir=''){
//		$uploadDir = urldecode($uploadDir);
//		if (empty($uploadDir)) $uploadDir = $this->uploadDirectory."/";
//  		$objResponse = new xajaxResponse();
//  		if (file_exists($uploadDir.'/'.$file)){
//	   		unlink($uploadDir.'/'.$file);
//			$objResponse->addScript("document.getElementById('".$file."').innerHTML=''");
//  		}
//  		return $objResponse->getXML();
//	}
//
//	// $id bs_images_group
//	function addUploadedFiles($id=0, $uploadDir=''){
//		if (empty($uploadDir)) $uploadDir = $this->uploadDirectory."/";
//		if (empty($id)){
//			$sql = $this->db->prepare("INSERT INTO ".DB_PREFIX."images_group(Created) VALUES (NOW())");
//			if ($this->db->Execute($sql)){
//				$id = $this->db->Insert_ID(DB_PREFIX."images_group","ID");
//			}
//		}
//		if ($id!=false && $id!=0){
//	    	$sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."tmp_images WHERE UserID='".$this->user->id."' ORDER BY ID ASC");
//	    	$res = $this->db->execute($sql);
//	    	if ($res && $res->RecordCount() > 0){
//	        	while (!$res->EOF){
//			        copy(tmpuploadDirectory.$res->fields["Image"],$uploadDir.$res->fields["Image"]);
//			        chmod($uploadDir.$res->fields["Image"],0777);
//			        if ($res->fields["ImageResize"]){
//				        copy(tmpuploadDirectory.$res->fields["ImageResize"],$uploadDir.$res->fields["ImageResize"]);
//				        chmod($uploadDir.$res->fields["ImageResize"],0777);
//			        }
//		           	$insql =$this->db->prepare("INSERT INTO ".DB_PREFIX."images(GroupID,Name,Image,ImageResize) VALUES ('".$id."','".$res->fields["Name"]."','".$res->fields["Image"]."','".$res->fields["ImageResize"]."')");
//			       	if( $this->db->execute($insql)){
//				       	unlink(tmpuploadDirectory.$res->fields["Image"]);
//				       	unlink(tmpuploadDirectory.$res->fields["ImageResize"]);
//				       	$this->db->execute("DELETE FROM ".DB_PREFIX."tmp_images WHERE ID='".$res->fields["ID"]."'");
//			       	}
//			       	$res->MoveNext();
//	        	}
//	    	}
//		}
//		return $id;
//	}
//
//	// $id bs_images_group
//	function moveUploadedFiles($uploadDir=''){
//		if (empty($uploadDir)) $uploadDir = $this->uploadDirectory."/";
//    	$sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."tmp_images WHERE UserID='".$this->user->id."' ORDER BY ID ASC");
//    	$res = $this->db->execute($sql);
//    	if ($res && $res->RecordCount() > 0){
//        	while (!$res->EOF){
//		        copy(tmpuploadDirectory.$res->fields["Image"],$uploadDir.$res->fields["Image"]);
//		        chmod($uploadDir.$res->fields["Image"],0777);
//
//		       	unlink(tmpuploadDirectory.$res->fields["Image"]);
//				$this->db->execute("DELETE FROM ".DB_PREFIX."tmp_images WHERE ID='".$res->fields["ID"]."'");
//		       	$res->MoveNext();
//	        	}
//	    	}
//	}
//
//	function deleteImagesGroup($groupID, $uploadDir=''){
//		if (empty($uploadDir)) $uploadDir = $this->uploadDirectory."/";
//		$sql = "SELECT ID FROM ".DB_PREFIX."images WHERE GroupID='".$groupID."'";
//		$res = $this->db->Execute($sql);
//		if ($res && $res->RecordCount() > 0){
//			while (!$res->EOF){
//				$this->delete_image($res->fields["ID"], $uploadDir);
//				$res->MoveNext();
//			}
//		}
//		$sql = "DELETE FROM ".DB_PREFIX."images_group WHERE ID='".$groupID."'";
//		$res = $this->db->Execute($sql);
//	}
	
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

    function prepareData($data){
        if (!isset($data['Published'])) $data['Published'] = 0;
        $data['UserID'] = $this->user->id;
        $data['Type'] = $this->type;
        $data['Lang'] = $this->language;
        $values = array();
        foreach ($this->fields as $item){
            if ($item=='ID'){
                if (!empty($data[$item])) $values[$item] = mysql_real_escape_string($data[$item]);
            } else $values[$item] = mysql_real_escape_string($data[$item]);
        }
        return $values;
    }

    function add($data){
        $data = $this->prepareData($data);
        $sql = $this->db->prepare("INSERT INTO " . $this->table . "(
            `" . implode('`,`', array_keys($data)) . "`
            ) VALUES (
            '" . implode("','", array_values($data)) . "'
            )");
        if ($this->db->Execute($sql)) return true;
        return false;
    }

    function change($data){
        $data = $this->prepareData($data);
        $upd = array();
        foreach ($data as $field=>$value){
            $upd[] = "`".$field."` = '".$value."'";
        }
        $sql = $this->db->prepare("UPDATE " . $this->table . " SET ".implode(",", $upd)." WHERE ID='".$data['ID']."'");
        if ($this->db->Execute($sql)) return true;
        return false;
    }

    function delete($ids){
        if (!is_array($ids) && preg_match("/[\d\,\s]+/", $ids)) $ids = explode(',', $ids);
        $ids = array_unique($ids);

        if (count($ids) <= 0) return array();

        $sql = $this->db->prepare("DELETE FROM " . $this->table . " WHERE id IN ('" . implode("','", $ids) . "')");
        $res = $this->db->Execute($sql);
        if ($res){
            return $ids;
        } else return array();
    }

    function deleteRecursive($data){
        $ids = explode(',', $data['ids']);
        $ids = array_unique($ids);

        if (count($ids) <= 0) return array();
        
        $delete = array();
        foreach ($ids as $id) {
            $delete[] = array('id' => $id);
            $delete = array_merge_recursive($this->getTreeListByParent($id), $delete);
        }
        $ids = array();
        foreach($delete as $item){
            $ids[] = $item['id'];
        }
        return $this->delete($ids);
    }

    function setType($type){
        $this->type = $type;
    }

    function getTreeListByParent($parent_id = 0, $ret = array(), $depth = 0) {
        if (isset($this->fields) && !in_array('ParentID', $this->fields)) return array();

        $depth++;
        $sql = "SELECT ID, Name FROM " . $this->table . " WHERE ParentID='" . $parent_id . "' AND Lang='" . $this->language . "' ORDER BY ID";
        $res = $this->db->Execute($sql);
        if ($res && $res->RecordCount() > 0) {
            while (!$res->EOF) {
                $depth_str = '';
                for ($i = 0; $i < $depth; $i++) $depth_str .= '-';
                $ret[] = array(
                    'id' => $res->fields["ID"],
                    'name' => $depth_str . $res->fields["Name"]
                );

                $ret = $this->getTreeListByParent($res->fields["ID"], $ret, $depth);
                $res->MoveNext();
            }
        }
        return $ret;
    }

    function getTabContent() {
        return $this->getValue();
    }
}
?>
