<?php
class SearchCatalog{

  var $moduleName; // module name
  var $tpl; // tpl to show
  
  var $db;
  var $smarty;
  var $lang;
  var $language;
  var $LangID;
  
  var $page; //navigation page
  var $navigationLimit; // items per page
  
  var $search_arr;
  
 
  function SearchCatalog($mod_name, $search_arr,$page=0){
    global $smarty,$db,$lang,$language,$LangID;
    
    $this->moduleName = $mod_name;
    $this->db = &$db;
    $this->smarty = &$smarty;
    $this->lang = &$lang;
    $this->language = $language;
    $this->LangID = $LangID;
    
    $this->search_arr = $search_arr;
    
    $this->page = $page;
    $this->navigationLimit = navigationLimit;
  }
  
  
   function getInfo(){
    $sql = "";
    $items = array();
    $sql = $this->db->prepare("SELECT *, Match(Name, Description) AGAINST ('".implode("|",$this->search_arr)."') as rel FROM ".CAT_PREFIX."item WHERE Name REGEXP '".implode("|",$this->search_arr)."' OR Description REGEXP '".implode("|",$this->search_arr)."' ORDER BY rel DESC"); 
    $sql .= " LIMIT ".$this->navigationLimit*$this->page.",".$this->navigationLimit;
    $sql = $this->db->prepare($sql);
	
    $this->tpl = "catalog.tpl";
    if (!empty($sql)){
      $res = $this->db->execute($sql);
      if ($res && $res->RecordCount() > 0){
         $items = $res->GetArray();
      }
    }
    return $items;
  }
  
  function Navigation(){
    $count = 0;
    $sql = $this->db->prepare("SELECT COUNT(*) as cnt FROM ".CAT_PREFIX."item WHERE Name REGEXP '".implode("|",$this->search_arr)."' OR Description REGEXP '".implode("|",$this->search_arr)."'");
    $res = $this->db->Execute($sql);
    if ($res && $res->RecordCount() > 0) {
      $count = $res->fields["cnt"];
    }
    $nav = new Navigator($count, $this->navigationLimit, $this->page);
    $nav->tpl = 'nav.tpl';
    $link = 'index.php?mod=' . $this->moduleName . '&mode=catalog';
    if ($_GET['text']){
      $link .= '&text='.$_GET['text'];
    }
    return $nav->show($link);
  }
  
  
	function getPath(){
		$path = array();
		$path[]  = array('Name'=>$this->lang['catalog'], 'LinkPath'=> CATALOG_ROOT_URL);
		$path[]  = array('Name'=>$this->lang['search'], 'LinkPath'=> LinkHelper::getLink('/index.php?mod=search'));
		return $path;
	}
  
   function show(){
	$this->smarty->assign("breadcrumbs", showBreadCrumbs($this->getPath()));
    $this->smarty->assign("item_arr",$this->getInfo());
    $this->smarty->assign("navigation",$this->Navigation());
    $this->smarty->assign("uploadDir",catalogUploadDirectory);
    $this->smarty->assign("uploadDirURL",catalogUploadDirectoryURL);
    return $this->smarty->fetch(strtolower($this->moduleName)."/".$this->tpl,null,$this->language);
  }
}
?>