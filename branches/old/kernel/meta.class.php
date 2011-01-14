<?
class Meta{
	var $meta_title = "";
	var $meta_description = "";
	var $meta_keywords = "";
	var $meta_alt = "";
	
	function Meta(){
	global $db;
		$sql = $db->prepare("SELECT * FROM ".DB_PREFIX."meta");
		$res = $db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			while (!$res->EOF){
				switch ($res->fields["MetaName"]){
					case "meta_title":
						$this->meta_title = $res->fields["MetaValue"];
						break;
					case "meta_keywords":
						$this->meta_keywords = $res->fields["MetaValue"];
						break;
					case "meta_description":
						$this->meta_description = $res->fields["MetaValue"];
						break;
					case "meta_alt":
						$this->meta_alt = $res->fields["MetaValue"];
						break;
				}

				$res->MoveNext();
			}
		}
	}
	
	
	
	function set_title($title){
		$title = trim($title);
		if (empty($title)) return ;
		if (!empty($this->meta_title)){
			$this->meta_title = $title.' - '.$this->meta_title;
		} else $this->meta_title = $title;
	}
	function set_description($description){
		$description = trim($description);
		if (empty($description)) return ;
		if (!empty($this->meta_description)){
			$this->meta_description = $description.' - '.$this->meta_description;
		} else $this->meta_description = $description;
	}
	function set_keywords($keywords){
		$keywords = trim($keywords);
		if (empty($keywords)) return ;
		if (!empty($this->meta_keywords)){
			$this->meta_keywords = $keywords.' - '.$this->meta_keywords;
		} else $this->meta_keywords = $keywords;
	}
	function set_alt($alt){
		$alt = trim($alt);
		if (empty($alt)) return ;
		if (!empty($this->meta_alt)){
			$this->meta_alt = $alt.' - '.$this->meta_alt;
		} else $this->meta_alt = $alt;
	}
}
?>