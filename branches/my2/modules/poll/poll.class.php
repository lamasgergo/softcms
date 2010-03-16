<?php

class Poll {
	var $block_vars;
	var $dynamic;
	var $moduleName; // module name
	
	var $langID;
	

	var $db;
	var $smarty;
	
	// vars for classes
	//common
	var $mode = 'poll';
	var $id;
	var $page;
	
	var $menu;
	var $items;
	var $voted=0;
	var $random = 0;
	
	function Poll($mod_name, $block_vars, $dynamic) {
		global $db, $smarty, $language, $LangID;
		$this->moduleName = $mod_name;
		$this->block_vars = $block_vars;
		$this->dynamic = $dynamic;
		$this->language = $language;
		
		$this->db = &$db;
		$this->smarty = $smarty;
		
		$this->langID = $LangID;
		
		$this->language = $language;
		
		$this->getVars ();
		
		$this->add ();
	}
	
	function add() {
		if (isset ( $_POST ['vote'] )) {
			$vote_id = $_POST ['vote'];
			$addr = $this->get_ip ();
			if (! $this->hasPoll ()) {
				$sql = $this->db->prepare ( "INSERT INTO " . POLL_PREFIX . "votes(CategoryID, QuestionID, IP, Proxy, Created) VALUES('" . $this->id . "', '".$vote_id."', '" . $addr ['ip'] . "','" . $addr ['proxy'] . "',NOW())" );
				$res = $this->db->Execute ( $sql );
			}
		}
	}
	
	function getQuestions() {
		$ret = array ( );
		
		$sql = $this->db->prepare ( "SELECT * FROM " . POLL_PREFIX . "item WHERE CategoryID='" . $this->id . "' ORDER BY OrderNum ASC" );
		
		$res = $this->db->Execute ( $sql );
		if ($res && $res->RecordCount () > 0) {
			return $res->getArray ();
		}
		return array ( );
	}

	function getCatgoryInfo() {
		$ret = array ( );
		$sql = $this->db->prepare ( "SELECT * FROM " . POLL_PREFIX . "category WHERE ID='" . $this->id . "'" );
		$res = $this->db->Execute ( $sql );
		if ($res && $res->RecordCount () > 0) {
			return $res->getArray ();
		}
		return array ( );
	}
	
	function getGraph() {
		$ret = array ( );
		$i=0;
		$res = $this->db->Execute("SELECT COUNT(*) as total FROM ".POLL_PREFIX."votes WHERE CategoryID='".$this->id."'");
		$total = $res->fields['total'];
		
		$sql = $this->db->prepare ( "SELECT * FROM " . POLL_PREFIX . "item WHERE CategoryID='" . $this->id . "' ORDER BY OrderNum ASC" );
		$res = $this->db->Execute ( $sql );
		if ($res && $res->RecordCount () > 0) {
			while (!$res->EOF){
				$ret[$i]['ID'] = $res->fields['ID'];
				$ret[$i]['Name'] = $res->fields['Name'];
				$res2 = $this->db->Execute("SELECT count(*) as count FROM ".POLL_PREFIX."votes WHERE QuestionID='".$res->fields['ID']."'");
            	if ($res2 && $res2->RecordCount() >0){
            		$ret[$i]['Persent'] = round(($res2->fields['count']*100)/$total, 1);
            	}
				$res->MoveNext();
				$i++;	
			}
			return $ret;
		}
		return array ( );
	}
	
	function hasPoll() {
		if (isset ( $_SERVER ['HTTP_X_FORWARDED_FOR'] )) {
			$proxy = $_SERVER ['REMOTE_ADDR'];
			$ip = $_SERVER ['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER ['REMOTE_ADDR'];
			$proxy = '';
		}
		
		$sql = $this->db->prepare ( "SELECT ID FROM " . POLL_PREFIX . "votes WHERE IP='" . $ip . "' AND Proxy='" . $proxy . "' AND CategoryID='" . $this->id . "'" );
		$res = $this->db->Execute ( $sql );
		if ($res && $res->RecordCount () > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function get_ip() {
		if (isset ( $_SERVER ['HTTP_X_FORWARDED_FOR'] )) {
			$proxy = $_SERVER ['REMOTE_ADDR'];
			$ip = $_SERVER ['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER ['REMOTE_ADDR'];
			$proxy = '';
		}
		return array ('ip' => $ip, 'proxy' => $proxy );
	}
	
	function getVars() {
		if ($this->dynamic==false){
			if (isset ( $this->block_vars ["id"] ) && ! empty ( $this->block_vars ["id"] )) {
				$this->id = $this->block_vars ["id"];
			}
			// must be the last
			if (isset ( $this->block_vars ["random"] ) && ! empty ( $this->block_vars ["random"] )) {
				$this->random = $this->block_vars ["random"];
				if ($this->random==1){
					$sql = $this->db->prepare("SELECT ID FROM ".POLL_PREFIX."category WHERE LangID='".$this->langID."' ORDER BY RAND() LIMIT 0,1");
					$res = $this->db->Execute($sql);
					if ($res && $res->RecordCount() > 0){
						$this->id = $res->fields['ID'];
					}
				}
			}
		} else {
			if (isset ( $_GET["id"] ) && ! empty ( $_GET["id"] )) {
				$this->id = intval($_GET["id"]);
			}
			if (isset ( $_GET["voted"] ) && ! empty ( $_GET["voted"] )) {
				$this->voted = intval($_GET["voted"]);
			}
		}
		if (isset ( $_POST["poll_id"] ) && ! empty ( $_POST["poll_id"] )) {
			$this->id = intval($_POST["poll_id"]);
		}
		
	}
	
	function show() {
		if ($this->hasPoll () || ($this->dynamic==true && $this->voted==1)) {
			$this->smarty->assign ( "items", $this->getGraph () );
			$tpl = 'results';
		} else {
			$this->smarty->assign ( "items", $this->getQuestions () );
			$tpl = 'form';
		}
		$this->smarty->assign ( "category", $this->getCatgoryInfo () );
		$this->smarty->assign ( "poll_id", $this->id );
		return $this->smarty->fetch ( strtolower ( $this->moduleName ) . "/" . $tpl . ".tpl", null, $this->language );
	}

}
?>
