<?php

class Comments{
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
	
	var $item; 
	var $itemID;
	var $defaultApprovedValue = 1;
	
	var $user;

	var $page;
	var $max_per_page;
	var $where;
	var $navigationLimit;

	function Comments($item, $item_id){
		global $smarty,$db,$lang,$language,$LangID, $meta, $user;
		
		$this->moduleName = 'comments';
		$this->db = $db;
		$this->smarty = $smarty;
		$this->lang = $lang;
		$this->language = $language;
		$this->LangID = $LangID;
		$this->user = $user;

		$this->page = $page;
		$this->navigationLimit = navigationLimit;
		$this->where = array();

		$this->item = $item;
		$this->itemID = $item_id;
		
		$this->getVars();
		
		$this->tpl = 'comments.tpl';
	}
	
	function getVars(){
		$this->where[] = "Approved='1'";
		
		if (isset($this->item) && !empty($this->item)){
			$this->where[] = "Item='".$this->item."'";		
		}
		if (isset($this->itemID) && !empty($this->itemID)){
			$this->where[] = "ItemID='".$this->itemID."'";		
		}
		
		if (isset($_GET["page"]) && !empty($_GET["page"])){
			$this->page = intval($_GET["page"]);
		}
		if (isset($_POST) && isset($_POST['add_comment'])){
			$this->addComment($_POST);			
		}
	}
	
	function removeSymbols($str){
		$str = preg_replace("/[\=\;]+/"," ",$str);
		return $str;		
	}
	
	function addComment($data){
		foreach ($data as $key=>$val){
			$val = $this->removeSymbols($val);
			$val = mysql_real_escape_string($val);
			$data[$key] = $val;
		}
		
		if (isset($data['add_comment']) && !empty($data['add_comment'])){
			
			$user_id = ($this->user->id) ? $this->user->id : 0;
			
			$sql = $this->db->prepare("INSERT INTO ".DB_PREFIX."comments
			(
				Item, 
				ItemID,
				Comment, 
				Approved, 
				UserID, 
				Created
			) VALUES (
				'".$this->item."',
				'".$data['item_id']."',
				'".$data['comment_text']."',
				'".$this->defaultApprovedValue."',
				'".$user_id."',
				NOW()
			)");
			$this->db->Execute($sql);
			$id = $this->db->Insert_ID(DB_PREFIX."comments","ID");
		    if (isset($id) && !empty($id)){
				$this->updateCounters($data['item_id']);
		    }
		    header('Location: '.$_SERVER['REQUEST_URI']);
		    exit();
		}
	}
	
	function updateCounters($id){
		if (empty($id)) return;
		if (empty($this->item)) return;
		
		switch ($this->item){
			case "content":
				$sql = $this->db->prepare("UPDATE ".DB_PREFIX."cnt_item SET CommentsCount=(SELECT COUNT(*) FROM ".DB_PREFIX."comments WHERE Item='content' AND ItemID='".$id."') WHERE ID='".$id."'");
				$this->db->Execute($sql);
			break;
		}
	}
	
	function getData(){
		$items = array();
		
		$sql = "SELECT * FROM ".DB_PREFIX."comments";
		$sql .= (count($this->where) > 0) ? ' WHERE '.implode(" AND ",$this->where) : '';
		$sql .= ' ORDER BY Created DESC';
		$sql .= " LIMIT ".$this->navigationLimit*$this->page.",".$this->navigationLimit;
		$sql = $this->db->prepare($sql);
		$res = $this->db->execute($sql);
		if ($res && $res->RecordCount() > 0){
			 $items = $res->GetArray();
		}
		foreach ($items as $key=>$item){
			$items[$key]['Comment'] = $this->fixHTML($item['Comment']);
		}
		return $items;
	}
	
	function Navigation(){
		$count = 0;
		$sql = "SELECT COUNT(ID) as cnt FROM ".DB_PREFIX."comments";
		$sql .= (count($this->where) > 0) ? ' WHERE '.implode(" AND ",$this->where) : '';

		$sql = $this->db->prepare($sql);
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			$count = $res->fields["cnt"];	
		}
		$nav = new Navigator($count,$this->navigationLimit,$this->page);
		$nav->tpl = 'nav_all.tpl';
		$link = $_SERVER['REQUEST_URI'];
		
		return $nav->show($link);
	}
	
	function fixHTML($text){
		$text = preg_replace("/\r?\n/","<br/>",$text);
		$text = preg_replace("/\s/","&nbsp;",$text);
		return $text;
	}
	
	function show(){
		$items = $this->getData();
		
		$this->smarty->assign("comments_arr",$items);

		$this->smarty->assign("comments_navigation",$this->Navigation());

		if (!empty($this->template) && file_exists($this->smarty->template_dir."/".strtolower($this->moduleName)."/".$this->template.'.tpl')){
			return $this->smarty->fetch($this->smarty->template_dir."/".strtolower($this->moduleName)."/".$this->template.'.tpl',null,$this->language);
		} else {
			return $this->smarty->fetch(strtolower($this->moduleName)."/".$this->tpl,null,$this->language);
		}
	}
}
?>