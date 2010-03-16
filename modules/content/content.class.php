<?php
class Content{
	var $moduleName;
	var $tpl;
	var $template;

	var $db;
	var $smarty;
	var $lang;
	var $language;
	var $LangID;

	var $block_vars;
	var $dynamic;
	
	var $cid; // category id
	var $pid; // parent id
	var $iid; // item id
	var $lid; // show last item from category

	var $page;
	var $max_per_page;
	var $where;
	
	var $meta;
	var $date;
	var $details;
	
	var $comments;
	
	var $data;
	
	function Content($block_vars,$dynamic,$page=0){
		global $smarty,$db,$lang,$language,$LangID, $meta;
		$this->moduleName = 'content';
		$this->db = $db;
		$this->smarty = $smarty;
		$this->lang = $lang;
		$this->language = $language;
		$this->LangID = $LangID;

		$this->page = $page;
		$this->navigationLimit = navigationLimit;
		$this->where = array();

		$this->block_vars = $block_vars;
		$this->dynamic = $dynamic;
		
		$this->meta = &$meta;
		
		$this->getVars();

		$this->comments = new Comments('content',$this->iid);
	}

	function getVars(){
		if ($this->dynamic==false){
			if (isset($this->block_vars["cid"]) && !empty($this->block_vars["cid"])){
				$this->cid = $this->block_vars["cid"];
				$this->where[] = "CategoryID='".$this->cid."'";
			}
			if (isset($this->block_vars["pid"]) && !empty($this->block_vars["pid"])){
				$this->pid = $this->block_vars["pid"];
				$this->where[] = "ParentID='".$this->pid."'";
			}
			if (isset($this->block_vars["iid"]) && !empty($this->block_vars["iid"])){
				$this->iid = $this->block_vars["iid"];
			}
			if (isset($this->block_vars["lid"]) && !empty($this->block_vars["lid"])){
				$this->lid = $this->block_vars["lid"];
			}
			if (isset($this->block_vars["tpl"]) && !empty($this->block_vars["tpl"])){
				$this->template = $this->block_vars["tpl"];
			}
			if (isset($this->block_vars["limit"]) && !empty($this->block_vars["limit"])){
				$this->navigationLimit = $this->block_vars["limit"];
			}
		} else {
			if (isset($_GET["cid"]) && !empty($_GET["cid"])){
				$this->cid = intval($_GET["cid"]);
				$this->where[] = "CategoryID='".$this->cid."'";
			}
			if (isset($_GET["pid"]) && !empty($_GET["pid"])){
				$this->pid = intval($_GET["pid"]);
				$this->where[] = "ParentID='".$this->pid."'";
			}
			if (isset($_GET["iid"]) && !empty($_GET["iid"])){
				$this->iid = intval($_GET["iid"]);
			}
			if (isset($_GET["lid"]) && !empty($_GET["lid"])){
				$this->lid = intval($_GET["lid"]);
			}
			if (isset($_GET["tpl"]) && !empty($_GET["tpl"])){
				$this->template = strval($_GET["tpl"]);
			}
			if (isset($_GET["page"]) && !empty($_GET["page"])){
				$this->page = intval($_GET["page"]);
			}
			if (isset($_GET["date"]) && !empty($_GET["date"])){
				$this->date = strval($_GET["date"]);
			}
		}
	}
	
	function get_cnt_categories_row($id,$row = "", $depth = 0){
		$depth++;
		$sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."cnt_category WHERE LangID='".$this->LangID."' AND ParentID='".$id."' ORDER BY Name ASC");
		$res = $this->db->execute($sql);
		if ($res && $res->RecordCount() > 0){
			while (!$res->EOF){
				$depth_value = "";
				for ($i=1;$i<$depth;$i++) $depth_value.='&nbsp;&nbsp;';
				$this->smarty->assign("depth",$depth_value);
				$this->smarty->assign("ID",$res->fields["ID"]);
				$this->smarty->assign("Name",$res->fields["Name"]);
				$row .= $this->smarty->fetch('content/category_row.tpl', null, $this->language);
				$row = $this->get_cnt_categories_row($res->fields["ID"],$row,$depth);

				$res->MoveNext();
			}
		} else {
			return $row;
		}

		return $row;
	}
	
	function getInfo(){
		$sql = "";
		$items = array();
		if (!empty($this->iid)){
			
			if ($this->dynamic){
				$this->updateViewCount();
			}
			
			$sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."cnt_item WHERE ID='".$this->iid."'");
			$this->tpl = "item_details.tpl";
		}
		if (!empty($this->cid) && empty($this->iid)){
			if (!empty($this->date) && preg_match("/(\d{2})\-(\d{2})\-(\d{4})/",$this->date, $match)){
				if ($match[1] && $match[2] && $match[3]){
					$this->where[] = "DATE(Created)='".$match[3]."-".$match[2]."-".$match[1]."'";
				}
			}
			$this->where[] = "Published='1'";
			
			$sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."cnt_item");
			$this->tpl = "category.tpl";
			$sql .= (count($this->where) > 0) ? ' WHERE '.implode(" AND ",$this->where) : '';
			$sql .= ' ORDER BY Created DESC';
			$sql .= " LIMIT ".$this->navigationLimit*$this->page.",".$this->navigationLimit;
		}
		if (!empty($this->lid)){
			$sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."cnt_item WHERE CategoryID='".$this->lid."' ORDER BY ID DESC LIMIT 0,1");
			$this->tpl = "item_details.tpl";
		}
		
		
		if (!empty($this->cid) || !empty($this->lid)){
			$sql2 = $this->db->prepare("SELECT * FROM ".DB_PREFIX."cnt_category WHERE ID='".$this->cid."'");
			$res2 = $this->db->execute($sql2);
			if ($res2 && $res2->RecordCount() > 0){
				 $this->details = $res2->GetArray();
			}
		}
		
		if (!empty($sql)){
			$res = $this->db->execute($sql);
			if ($res && $res->RecordCount() > 0){
				 $items = $res->GetArray();
			}
		}
		
		$this->data = $items;
		
		return $items;
	}
	
	function updateViewCount(){
		if (empty($this->iid)) return;
		$sql = $this->db->prepare("UPDATE ".DB_PREFIX."cnt_item SET ViewCount=ViewCount+1 WHERE ID='".$this->iid."'");
		$this->db->Execute($sql);
	}
	
	function Navigation(){
		$count = 0;
		$sql = $this->db->prepare("SELECT COUNT(ID) as cnt FROM ".DB_PREFIX."cnt_item");
		$sql .= (count($this->where) > 0) ? ' WHERE '.implode(" AND ",$this->where) : '';
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			$count = $res->fields["cnt"];	
		}
		$nav = new Navigator($count,$this->navigationLimit,$this->page);
		$nav->tpl = 'nav_all.tpl';
		$link = 'index.php?mod=' . $this->moduleName;
		if (!empty($_GET['tpl'])){
			$link .= "&tpl=".$_GET['tpl'];
		}
		if (!empty($this->cid)){
			$link .= "&cid=".$this->cid;
		}
		return $nav->show($link);
	}
	
	function allowComments(){
		if (!empty($this->iid) && $this->dynamic){
			$sql = $this->db->prepare("SELECT i.AllowComments as item, c.AllowComments as cat FROM ".DB_PREFIX."cnt_item as i LEFT JOIN ".DB_PREFIX."cnt_category as c ON (c.ID=i.CategoryID) WHERE i.ID='".$this->iid."'");
			$res = $this->db->Execute($sql);
			if ($res && $res->RecordCount() > 0){
				if ($res->fields['item']=='1' || $res->fields['cat']==1) return true;
			}
		}
		return false;
	}
	
	function getPath(){
		$path = array();
		if ($this->iid){
			$path[]  = array('Name'=>$this->data[0]['Title'], 'LinkPath'=> $_SERVER['REQUEST_URI']);
		}
		if (!empty($this->cid) && empty($this->iid)){
			$sql = $this->db->prepare("SELECT ID, Name FROM ".DB_PREFIX."cnt_category WHERE ID='".$this->cid."'");
			$res = $this->db->Execute($sql);
			$path[]  = array('Name'=>$res->fields['Name'], 'LinkPath'=> $_SERVER['REQUEST_URI']);
		}
		return $path;
	}
	
	function show(){
		$items = $this->getInfo();
		
		#$this->smarty->assign("details",$this->details);
		$this->smarty->assign("item_arr",$items);
		if (!empty($this->cid)){
			$this->smarty->assign("navigation",$this->Navigation());
		}
		
		if (!empty($this->iid) && $this->dynamic){
			$this->meta->set_title($items[0]['MetaTitle']);
			$this->meta->set_description($items[0]['MetaDescription']);
			$this->meta->set_keywords($items[0]['MetaKeywords']);
			$this->meta->set_alt($items[0]['MetaAlt']);	

			if ($this->allowComments()){
				$this->smarty->assign("comments", $this->comments->show());
			}
		}

		if ($this->dynamic==true){
			$this->smarty->assign("breadcrumbs", showBreadCrumbs($this->getPath()));
		}
		
		if ($this->iid && count($items)==0 || !$this->tpl) return $this->smarty->fetch('error.tpl',null,$this->language);;
		if (!empty($this->template) && file_exists($this->smarty->template_dir."/".strtolower($this->moduleName)."/".$this->template.'.tpl')){
			return $this->smarty->fetch($this->smarty->template_dir."/".strtolower($this->moduleName)."/".$this->template.'.tpl',null,$this->language);
		} else {
			return $this->smarty->fetch(strtolower($this->moduleName)."/".$this->tpl,null,$this->language);
		}
	}
}
?>