<?php

require_once (MODULES_DIR . "/" . $mod_name . "/gallerymenu.php");
require_once (MODULES_DIR . "/" . $mod_name . "/gallerylist.php");
require_once (MODULES_DIR . "/" . $mod_name . "/galleryitems.php");

class Gallery {
	var $block_vars;
	var $dynamic;
	var $moduleName; // module name
	

	var $db;
	var $smarty;
	
	// vars for classes
	//common
	var $mode = 'gallery';
	var $id;
	var $page;
	
	var $menu;
	var $items;
	var $random=0;
	var $cid;
	var $limit=100;
	var $tpl;
	var $url;
	
	function Gallery($moduleName, $block_vars, $dynamic) {
		global $db, $smarty, $language;
		$this->moduleName = $mod_name;
		$this->block_vars = $block_vars;
		$this->dynamic = $dynamic;
		$this->language = $language;
		
		$this->db = &$db;
		$this->smarty = $smarty;
		$this->getVars ();
		if ($this->dynamic==false){
			if (!isset($this->tpl)){
				$tpl = 'block.tpl';
			} else {
				$tpl = $this->tpl.'.tpl';
			}
			$this->items = new GalleryItems ( $mod_name, $this->id, $this->cid, $this->random, $this->limit, $tpl, $this->url );
		} else{
			$this->menu = new GalleryMenu ( $mod_name, $block_vars, $dynamic );
			if ($this->id){
				$this->items = new GalleryItems ( $mod_name, $this->id );
			} else {
				$this->items = new GalleryList ( $mod_name, $this->cid, $this->page );
			}
		}
		
	}
	
	function getVars() {
		if ($this->dynamic == false) {
			if (isset ( $this->block_vars ["id"] ) && ! empty ( $this->block_vars ["id"] )) {
				$this->id = $this->block_vars ["id"];
			}
			if (isset ( $this->block_vars ["cid"] ) && ! empty ( $this->block_vars ["cid"] )) {
				$this->cid = $this->block_vars ["cid"];
			}
			if (isset ( $this->block_vars ["random"] ) && ! empty ( $this->block_vars ["random"] )) {
				$this->random = $this->block_vars ["random"];
			}
			if (isset ( $this->block_vars ["limit"] ) && ! empty ( $this->block_vars ["limit"] )) {
				$this->limit = $this->block_vars ["limit"];
			}
			if (isset ( $this->block_vars ["tpl"] ) && ! empty ( $this->block_vars ["tpl"] )) {
				$this->tpl = $this->block_vars ["tpl"];
			}
			
			if (isset ( $this->block_vars ["url"] ) && ! empty ( $this->block_vars ["url"] )) {
				$this->url = $this->block_vars ["url"];
			}
		} else {
			if (isset ( $_GET ["id"] ) && ! empty ( $_GET ["id"] )) {
				$this->id = intval ( $_GET ["id"] );
			}
			if (isset ( $_GET ["page"] ) && ! empty ( $_GET ["page"] )) {
				$this->page = intval ( $_GET ["page"] );
			}
		}
	}
	
	function show() {
		if ($this->menu){
			$this->smarty->assign ( "menu", $this->menu->show () );
		}
		$this->smarty->assign ( "items", $this->items->show () );
		return $this->smarty->fetch ( strtolower ( $this->moduleName ) . "/gallery.tpl", null, $this->language );
	}

}
?>
