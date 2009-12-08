<?php

class StatPages extends TabElement{

	/* Name of a Tab Element */
	var $name;

	/* Body of a Tab Element */
	var $value;

	/* Action menu for Tab Element */
	var $menu;

	/* Data Filter for Tab Element */
	var $filter;

	/* Name of a DIV where Tab Element will parsed */
	var $visual_div_name;

	/* Smarty object */
	var $smarty;

	/* Lang array with localization vars */
	var $lang;

	/* Var with lang ID for smarty templates engine */
	var $language;

	/* Main module name */
	var $mod_name;

	/* JS sortable params:
	 * false 	: don't sort
	 * 'S'		: string sorting
	 * 'N'		: numeric sorting
	 *
	 * example: false,'S','N',false,'S','S'
	 */
	var $sort_table_fields;

	function StatPages($mod_name,$tabID){
		$this->name=__CLASS__;
		$this->sort_table_fields = "'S',false,'S','S','N'";

		$this->addXajaxFunction($this->getName()."_filter");
		$this->addXajaxFunction($this->getName()."_refresh");

		parent::TabElement($mod_name);

		$this->setClassVars();
		
		//set current tab ID
		$this->tabID = $tabID;
		
		// set template and ajax vars
		$this->setTemplateVars();

	}

	function setClassVars(){
		// set common module path
		$this->tpl_path = strtolower($this->mod_name).'/'.strtolower($this->name);
	}
	
	function getName(){
		return strtolower(__CLASS__);
	}

	//set common template vars
	function setTemplateVars(){
		$this->smarty->assign("prefix",$this->mod_name);
		$this->smarty->assign("tab_prefix",$this->getName());
		$this->smarty->assign("sort_table_fields",$this->sort_table_fields);
	}

	function getTabContent(){
		return $this->getValue();
	}

	function getValue(){
		$filter_sql = $this->getFilterSQL();
		if (!empty($filter_sql)) $filter_sql = " WHERE ".$filter_sql;
		$sql = $this->db->prepare("SELECT Title,Link,Description,MAX(Visited) as Visited, COUNT(ID) as cnt  FROM ".DB_PREFIX."stat_pages".$filter_sql." GROUP BY Link ORDER BY cnt DESC");
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			$this->smarty->assign("items_arr",$res->getArray());
		} else $this->smarty->assign("items_arr",array());
		return $this->smarty->fetch($this->tpl_path.'/table.tpl',null,$this->language);
	}


	function statpages_refresh($tab_id){
		$objResponse = new xajaxResponse();
		$this->setClassVars();
		$this->setTemplateVars();
		$objResponse->addScriptCall("showTab","dhtmlgoodies_tabView1",$tab_id);
		$objResponse->addAssign($this->visual_div_name,'innerHTML',$this->getValue());
		$objResponse->addAssign('visualmenu_statpages','innerHTML',$this->getMenu());
		$objResponse->addScriptCall("initTableWidget","myTable","100%","480","Array(".$this->sort_table_fields.")");
		return $objResponse->getXML();
	}


	function getMenu(){
		$filter_sql = $this->getFilterSQL();
		if (!empty($filter_sql)) $filter_sql = " WHERE ".$filter_sql;
		$sql = $this->db->prepare("SELECT COUNT(ID) as cnt  FROM ".DB_PREFIX."stat_pages".$filter_sql);
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			$this->smarty->assign("count",$res->fields["cnt"]);
		} else $this->smarty->assign("count",0);
		return $this->smarty->fetch($this->tpl_path.'/common.tpl',null,$this->language);
	}

	function getFilter(){
		$filters = $this->filterVisited();
		return $filters;
	}

	function filterVisited(){
		$filter_name = "Visited";
		$sql = $this->db->prepare("SELECT ID,Name FROM ".ADB_PREFIX."vendors ORDER BY Name ASC");
		$res = $this->db->Execute($sql);
		$ids = array();
		$names = array();
		if ($res && $res->RecordCount() > 0){
			while (!$res->EOF){
				array_push($ids,$res->fields["ID"]);
				array_push($names,$res->fields["Name"]);
				$res->MoveNext();
			}
		}
		$this->smarty->assign($filter_name."_ids",$ids);
		$this->smarty->assign($filter_name."_names",$names);
		return $this->smarty->fetch($this->tpl_path.'/filters/'.$filter_name.'.tpl',null,$this->language);
	}

	function statpages_filter($name,$value1='',$value2=''){
		if (!empty($value1) && !empty($value2) && preg_match("/\d{4}\.\d{2}\.\d{2}/",$value1) && preg_match("/\d{4}\.\d{2}\.\d{2}/",$value1)){
			$value1 = preg_replace("/\./","-",$value1);
			$value2 = preg_replace("/\./","-",$value2);
			$this->addFilter(array("sql",'(DATE('.$name.') >= "'.$value1.'" AND DATE('.$name.') <= "'.$value2.'")'));
		}
		return $this->statpages_refresh($this->tabID);
	}

	function getFilterSQL(){
		$sql = "";
		if (count($this->filter) > 0){
			for ($i=0; $i < count ($this->filter); $i++){
				$filter = $this->filter[$i];
				if (!empty($filter[1]) && $filter[0]!="sql"){
					$sql .= $filter[0]."='".$filter[1]."'";
				} elseif ($filter[0]=="sql"){
					$sql .= $filter[1];
				}
				if ($i!=count($this->filter) && !empty($sql)) $sql .= " ";
			}
		}
		return $sql;
	}

}
?>
