<?php
class Navigator{

	var $moduleName;
	var $tpl;
	
	var $smarty;
	var $lang;
	var $language;
	
	var $count;
	var $page;
	var $navigationLimit;
	var $maxPages;
	
	function Navigator($count,$navigationLimit,$page=0){
		global $smarty,$lang,$language;
		$this->moduleName = "Navigator";
		$this->smarty = $smarty;
		$this->lang = $lang;
		$this->language = $language;
		
		$this->count = $count;
		$this->page = $page;
		$this->navigationLimit = $navigationLimit;
		$this->maxPages = navigatorMaxPages;
		$this->tpl = 'nav.tpl';
	}
	
	function getInfo($link){
		$link = preg_replace("/[\?\&\/]+page[\?\&\/\=]+\d+/", "", $link);
		$link = $link.'&page=';
		$pages = ceil($this->count/$this->navigationLimit);
		$total_pages = ceil( $this->count / $this->navigationLimit );
		$page	= $this->page+1;

		$start_loop	= (floor(($page-1)/$this->maxPages))*$this->maxPages+1;
		
		if ($start_loop + $this->maxPages - 1 < $total_pages) {
			$stop_loop = $start_loop + $this->maxPages - 1;
		} else {
			$stop_loop = $total_pages;
		}

		if ($page > 1) {
			$spage = $this->page-1;
			$this->smarty->assign("startLink",PageHelper::getStaticLink($link.$spage));
		}
		$arr = array();
		if ($stop_loop==0){
			//return list
			$arr[] = '<b>1</b>';	
		} else {
			for ($i=$start_loop; $i<=$stop_loop;$i++){
        		if ($i==$page){
        			$arr[] = '<b>'.$i.'</b>';
        		} else {
          			$arr[] = '<a class="navLink" style="position:relative;" href="'.PageHelper::getStaticLink($link.($i-1)).'">'.$i.'</a>';
        		}
      		}
			//return list
		}
		$this->smarty->assign("nav_arr",$arr);
		if ($page < $total_pages) {
			$spage = $this->page+1;
			$this->smarty->assign("endLink",PageHelper::getStaticLink($link.$spage));
		}
	}
	
	function show($link){
		$this->getInfo($link);
		return $this->smarty->fetch(strtolower($this->moduleName)."/".$this->tpl,null,$this->language);
	}
}
?>