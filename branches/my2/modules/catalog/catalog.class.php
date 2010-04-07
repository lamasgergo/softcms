<?php

require_once(MODULES_DIR."/".$mod_name."/cataloglist.php");
require_once(MODULES_DIR."/".$mod_name."/itemlist.php");
require_once(MODULES_DIR."/".$mod_name."/itemdetails.php");


class Catalog{
  var $block_vars;
  var $dynamic;
  var $moduleName; // module name
  
  var $obj;
  
  var $db;
  var $smarty;

  // vars for classes
  //common
  var $mode='category';
  var $id;
  var $page;
  //autolist
  var $place;

  var $categories;
  var $items;
  var $details;
  var $itemID; 
  var $categoryID = 0;
  var $lang;
  var $language;

  function Catalog($moduleName, $block_vars,$dynamic){
    global $db, $smarty, $lang, $language;
    $this->moduleName = $mod_name;
    $this->block_vars = $block_vars;
    $this->dynamic = $dynamic;
	$this->lang = $lang;
	$this->language = $language;
    
    $this->db = &$db;
    $this->smarty = $smarty;
    
    $this->getVars();
    
    if ($this->itemID){
        $this->details = new ItemDetails($this->moduleName, $this->itemID);
    } else {
        $this->categories = new CatalogList($this->moduleName, $this->categoryID);
        $this->items = new ItemList($this->moduleName, $this->categoryID, $this->page);
    }
  }
    
  function getVars(){
    if ($this->dynamic==false){
      if (isset($this->block_vars["mode"]) && !empty($this->block_vars["mode"])){
        $this->mode = $this->block_vars["mode"];
      }
      if (isset($this->block_vars["id"]) && !empty($this->block_vars["id"])){
		switch ($this->mode){
			case 'category' :
				$this->categoryID = intval($this->block_vars["id"]);
			break;
			case 'item' :
				$this->itemID = intval($this->block_vars["id"]);
			break;
		}
      }
    } else {
      if (isset($_GET["mode"]) && !empty($_GET["mode"])){
        $this->mode = strval($_GET["mode"]);
      }
      if (isset($_GET["id"]) && !empty($_GET["id"]) && $this->mode){
		switch ($this->mode){
			case 'category' :
				$this->categoryID = intval($_GET["id"]);
			break;
			case 'item' :
				$this->itemID = intval($_GET["id"]);
			break;
		}
      }
      if (isset($_GET["page"]) && !empty($_GET["page"])){
        $this->page = intval($_GET["page"]);
      }
      if (isset($_GET["static_path"]) && !empty($_GET["static_path"])){
        $this->parseStaticPath(strval($_GET["static_path"]));
      }
    }
  }
  
  function parseStaticPath($path=''){
	$path = preg_replace('/\/$/','', $path);
    $path = trim($path);
    if (strlen($path) > 0){
      $path_arr = explode("/",$path);
    }
    
  	$link = array_pop($path_arr);
    $sql = "SELECT ID, CategoryID, Description FROM ".CAT_PREFIX."item WHERE LinkAlias='".mysql_escape_string($link)."'";
    $res = $this->db->Execute($sql);
    if ($res && $res->RecordCount() > 0){
      $this->categoryID = $res->fields['CategoryID'];
      $this->itemID = $res->fields['ID'];
	  $catlink = array_pop($path_arr);
    } else {
		$catlink = $link;
	}
	
	$sql = "SELECT ID FROM ".CAT_PREFIX."category WHERE LinkAlias='".mysql_escape_string($catlink)."'";
	$res = $this->db->Execute($sql);
	if ($res && $res->RecordCount() > 0){
	  $this->categoryID = $res->fields['ID'];
	}
	
  }


  function getCategoryDescription(){
    if ($this->categoryID!=0){
      $sql = "SELECT Name, Description, MetaTitle, MetaDescription, MetaKeywords, MetaAlt FROM ".CAT_PREFIX."category WHERE ID='".$this->categoryID."'";
      $res = $this->db->Execute($sql);
      if ($res && $res->RecordCount() > 0){
        return $res->getArray();
      }
    }
    return '';
  }
  
  
  
  function show(){
	global $meta;
    $cat = $this->getCategoryDescription();
    $this->smarty->assign("current_category", $cat);
	
		if (empty($cat[0]['MetaTitle'])){
			$meta->set_title("---");
			$meta->set_description("---");
			$meta->set_keywords("---");
			$meta->set_alt("---");
		} else {
			$meta->set_title($cat[0]['MetaTitle']);
			$meta->set_description($cat[0]['MetaDescription']);
			$meta->set_keywords($cat[0]['MetaKeywords']);
			$meta->set_alt($cat[0]['MetaAlt']);
		}
	
    if ($this->dynamic===true){
		$this->smarty->assign("breadcrumbs", showBreadCrumbs($this->getPath()));
	}
	
    if ($this->itemID){
      $this->smarty->assign("items", $this->details->show());
    } else {
      $this->smarty->assign("catalogs", $this->categories->show());
      $this->smarty->assign("items", $this->items->show());
    }
    return $this->smarty->fetch(strtolower($this->moduleName) . "/catalog.tpl", null, $this->language);
  }
  
  
  function getPath(){
	$path = array();
	$path[] = array('LinkPath'=>CATALOG_ROOT_URL, 'Name'=>$this->lang['catalog']);
	if ($this->details->data['CategoryID']){
		$this->categoryID = $this->details->data['CategoryID'];
	}
    if ($this->categoryID!=0){
      $path = array_reverse($this->getPathTree($this->categoryID));
    } 
	if ($this->details){
		$path[] = array('LinkPath'=>$this->details->data['LinkAlias'], "Name"=>$this->details->data['Name']);
	}
	return $path;
  }
  
  function getPathTree($id, $arr=array()){
    $sql = "SELECT ParentID, Name, LinkPath, LinkAlias FROM ".CAT_PREFIX."category WHERE ID='".$id."'";
    $res = $this->db->Execute($sql);
    if ($res && $res->RecordCount() > 0){
	  $link = CATALOG_ROOT_URL.'/'.$res->fields['LinkPath'].'/'.$res->fields['LinkAlias'].'/';
	  $link = str_replace("//","/", $link);	
      $arr[] = array(
              "LinkPath"  => $link,
              "Name"  => $res->fields['Name']
            );
      $arr = $this->getPathTree($res->fields['ParentID'], $arr);
    } 
    return $arr;
  }
}
?>
