<?php
class CartModule{
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
	
	var $cart;
	
	var $step = 1;
	
	function CartModule($moduleName, $block_vars, $dynamic=false){
		global $smarty,$db,$lang,$language,$LangID, $cart;
		
		$this->moduleName = 'cart';
		$this->db = $db;
		$this->smarty = $smarty;
		$this->lang = $lang;
		$this->language = $language;
		$this->LangID = $LangID;

		$this->block_vars = $block_vars;
		
		$this->dynamic = $dynamic;
		
		$this->tpl = 'cart.tpl';
		
		$this->cart = $cart;
		
		$this->cart->load();
		$this->getVars();

	}

	function getVars(){
		if ($this->dynamic==false){
			if (isset($this->block_vars["tpl"]) && !empty($this->block_vars["tpl"])){
				$this->template = $this->block_vars["tpl"];
			}
		} else {
			if (isset($_GET['checkout'])){
				$this->tpl = 'checkout.tpl';
			}
			if (isset($_POST['submit_buy'])){
				$this->step = 2;
			}
		}
	}
	
		
	function getInfo(){
		$items = array();
		
		if (count($this->cart->items)>0){
			foreach ($this->cart->items as $item=>$count){
				$sql = "SELECT ID, Name, Description, (SELECT Name FROM ".CAT_PREFIX."category WHERE ID=CategoryID) as category, Price, (SELECT Value FROM ".DB_PREFIX."currency WHERE ID=PriceUnit) as PriceMulti FROM ".CAT_PREFIX."item WHERE ID='".$item."'";
				$sql = $this->db->prepare($sql);
				$res = $this->db->Execute($sql);
				if ($res && $res->RecordCount() > 0){
					list($data) = $res->getArray();
					$data['Count'] = $count; 
					$data['Sum'] = $data['Price'] * $data['PriceMulti'] * $data['Count'];
					$items[$data['ID']] = $data;
				}
			}
		}
		return $items;
	}
	
	function getPath(){
		$path = array();
		$path[]  = array('Name'=>$this->lang['cart'], 'LinkPath'=> LinkHelper::getLink('/index.php?mod=checkout'));
		return $path;
	}
	
	
	
	function show(){
		$items = $this->getInfo();
		$this->smarty->assign("item_arr",$items);
		
		if ($this->dynamic){
			$this->smarty->assign("breadcrumbs", showBreadCrumbs($this->getPath()));
		}
	
		$this->smarty->assign("step", $this->step);
		
		if ($this->step==2){
			$email_body = $this->smarty->fetch(strtolower($this->moduleName)."/request.tpl",null,$this->language);
			if (send_email(checkout_email, $this->lang['cart_request'], $email_body, checkout_email, checkout_email_name)){
				$this->tpl = 'request_sended.tpl';
			} else {
				$this->tpl = 'request_failed.tpl';
			}
		}
		
		
		if (!empty($this->template) && file_exists($this->smarty->template_dir."/".strtolower($this->moduleName)."/".$this->template.'.tpl')){
			return $this->smarty->fetch($this->smarty->template_dir."/".strtolower($this->moduleName)."/".$this->template.'.tpl',null,$this->language);
		} else {
			return $this->smarty->fetch(strtolower($this->moduleName)."/".$this->tpl,null,$this->language);
		}
	}
}
?>