<?php

define('CART_SESSION', SES_PREFIX."cart");

require_once(__PATH__.'/modules/cart/cart.class.php');

class Cart{
	var $user;
	var $items = array();
	
	var $xajax;
	var $smarty;
	var $db;
	var $lang;
	var $language;
	var $LangID;
	
	
	function Cart(){
		global $user, $smarty,$db,$lang,$language,$LangID, $xajax;
		
		$this->xajax = &$xajax;
		$this->db = $db;
		$this->smarty = $smarty;
		$this->lang = $lang;
		$this->language = $language;
		$this->LangID = $LangID;
		
		$xajax->registerFunction(array('cart_add', $this, 'cart_add'));
		$xajax->registerFunction(array('cart_update', $this, 'cart_update'));
		$xajax->registerFunction(array('cart_remove', $this, 'cart_remove'));
		$xajax->registerFunction(array('cart_refresh', $this, 'cart_refresh'));
		
		if ($user->is_auth()){
			$this->user = $user->userdata();
		}
		$this->load();
	}

	function load(){
		$this->items = $_SESSION['CART_SESSION'];
	}
	
	function save(){
		$_SESSION['CART_SESSION']= $this->items;
	}

	function cart_add($id){
		$resp = new xajaxResponse();
		$this->load();
		if ($this->items[$id]){
			$this->items[$id] = $this->items[$id] + 1;
		} else $this->items[$id] = 1;
		$this->save();
		return $resp->getXML();
	}
	
	function cart_update($id, $count){
		$resp = new xajaxResponse();
		$this->load();
		if ($this->items[$id]){
			$this->items[$id] = $count;
		}
		$this->save();
		return $resp->getXML();
	}
	
	function cart_remove($id){
		$resp = new xajaxResponse();
		$this->load();
		if ($this->items[$id]){
			unset($this->items[$id]);
		}
		$this->save();
		return $resp->getXML();
	}
	
	
	function cart_refresh(){
		$resp = new xajaxResponse();
		$cart = new CartModule(array(), true, false);
		$resp->addAssign('cart_block', 'innerHTML', $cart->show());
		return $resp->getXML();
	}
	
}
$cart = new Cart();

?>
