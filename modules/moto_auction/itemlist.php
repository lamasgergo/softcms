<?php
class ItemList{
	
	var $moduleName; // module name
	var $tpl; // tpl to show
	

	var $db;
	var $smarty;
	var $lang;
	var $language;
	var $LangID;
	var $user;
	var $xajax;
	
	var $where = array('Published="1"');
	
	var $page; //navigation page
	var $navigationLimit; // items per page
	
	var $priceUpValue = 100;

	var $uploadDir;
	var $uploadDirURL;
	
	var $emailSubject;
	var $emailFrom = infoFromEmail;
	var $emailFromName = infoFromEmailName;
	
	function ItemList($mod_name, $page = 0){
		global $smarty, $db, $lang, $language, $LangID, $user, $xajax;
		
		$this->uploadDir = catalogUploadDirectory;
		$this->uploadDirURL = catalogUploadDirectoryURL;
		
		$this->moduleName = $mod_name;
		$this->db = &$db;
		$this->smarty = &$smarty;
		$this->user = &$user;
		$this->xajax = &$xajax;
		$this->lang = $lang;
		$this->language = $language;
		$this->LangID = $LangID;
		$this->where = array();
		
		$this->xajax->registerFunction(array('price_up',$this,'price_up'));
		
		$this->page = $page;
		$this->navigationLimit = navigationLimit;
		
		$this->getWhere();
	}
	
	function checkExpiredItems(){
		$sql = $this->db->prepare("SELECT ID FROM ".MOTO_AUC_PREFIX."item WHERE EndDate < CURRENT_DATE() AND Status='Exists'");
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			while (!$res->EOF){
				$sql = $this->db->prepare("UPDATE ".MOTO_AUC_PREFIX."item SET Status='Not Exists' WHERE ID='".$res->fields['ID']."'");
				$this->db->Execute($sql);
				$this->sendLetterToUser($res->fields['ID']);
				$res->MoveNext();
			}	
		}
	}
	
	function getWhere(){
		$this->where[] = "CURRENT_DATE() BETWEEN i.StartDate AND i.EndDate AND `Status`='Exists'";
		if (isset($_GET["categoryid"]) && !empty($_GET["categoryid"])){
			$catid=0;
			$itemName='';
			list($catid, $itemName) = explode(",",$_GET["categoryid"]);
			$catid = intval($catid);
			$itemName = trim(strval($itemName));
			if ($catid!=0 && $itemName!=''){
				$this->where[] = "(i.CategoryID='".$catid."' AND i.Name='".$itemName."')";
			}
		}
		if (isset($_GET["class"]) && !empty($_GET["class"])){
			$class = trim(strval($_GET["class"]));
			$this->where[] = "i.Class='".$class."'";
		}
	}
	
	function getInfo(){
		$sql = "";
		$items = array();
		$sql = "SELECT i.*, p.Price as userPrice FROM " . MOTO_AUC_PREFIX . "item AS i LEFT JOIN ".MOTO_AUC_PREFIX."prices AS p ON (p.ItemID=i.ID)";
		$sql .= (count($this->where) > 0) ? ' WHERE ' . implode(" AND ", $this->where) : '';
		$sql .= " LIMIT " . $this->navigationLimit * $this->page . "," . $this->navigationLimit.";";
		$sql = $this->db->prepare($sql);
		$this->tpl = "list.tpl";
		if (! empty($sql)) {
			$res = $this->db->execute($sql);
			if ($res && $res->RecordCount() > 0) {
				$items = $res->GetArray();
			}
		}
		return $items;
	}
	
	function Navigation(){
		$count = 0;
		$sql = $this->db->prepare("SELECT COUNT(ID) as cnt FROM " . MOTO_AUC_PREFIX . "item");
		$sql .= (count($this->where) > 0) ? ' WHERE ' . implode(" AND ", $this->where) : '';
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0) {
			$count = $res->fields["cnt"];
		}
		$nav = new Navigator($count, $this->navigationLimit, $this->page);
		$nav->tpl = 'nav_all.tpl';
		$link = 'index.php?mod=' . $this->moduleName . '&mode=list';
		if ($_GET['categoryid']){
			$link .= '&categoryid='.$_GET['categoryid'];
		}
		if ($_GET['class']){
			$link .= '&class='.$_GET['class'];
		}
		return $nav->show($link);
	}
	
	function show(){
		$this->smarty->assign("uploadDir", $this->uploadDir);
		$this->smarty->assign("uploadDirURL", $this->uploadDirURL);
		$this->smarty->assign("mod_name", $this->moduleName);
		$this->smarty->assign("item_arr", $this->getInfo());
		$this->smarty->assign("navigation", $this->Navigation());
		return $this->smarty->fetch(strtolower($this->moduleName) . "/" . $this->tpl, null, $this->language);
	}
	
	function price_up($id, $user_id){
		$objResponse = new xajaxResponse();
		$sql = $this->db->prepare("SELECT Price FROM " . MOTO_AUC_PREFIX . "prices WHERE ItemID='".$id."'");
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			$price = (int)$res->fields['Price'] + 100;
			$sql = $this->db->prepare("UPDATE ".MOTO_AUC_PREFIX."prices SET Price='".$price."' WHERE ItemID='".$id."'");
			$this->db->Execute($sql);
		} else {
			$sql = $this->db->prepare("SELECT Price FROM " . MOTO_AUC_PREFIX . "item WHERE ID='".$id."'");
			$res = $this->db->Execute($sql);
			if ($res && $res->RecordCount() > 0){
				$price = (int)$res->fields['Price'] + 100;
				$sql = $this->db->prepare("INSERT INTO ".MOTO_AUC_PREFIX."prices(ItemID, UserID, Price, Created) VALUES('".$id."','".$user_id."','".$price."',NOW())");
				$this->db->Execute($sql);
			}
		}
		$objResponse->addAssign('price_'.$id,'innerHTML', $price);
		return $objResponse->getXML();	
	}
	
	function sendLetterToUser($id){
		$sql = $this->db->prepare("SELECT u.Email as email, p.Price as price FROM ".MOTO_AUC_PREFIX."prices as p, ".DB_PREFIX."users as u WHERE u.ID=p.UserID AND p.ItemID='".$id."'");
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			$this->emailSubject = $this->lang[$this->moduleName.'_emailSubject'];
			$email = $res->fields['email'];
			$detail = new ItemDetails($this->moduleName, $id);
			$body = $detail->get();
			if(send_email($email, $this->emailSubject, $body, $this->emailFrom, $this->emailFromName)){
				echo 'Sended';	
			}
		}
	}
}
?>