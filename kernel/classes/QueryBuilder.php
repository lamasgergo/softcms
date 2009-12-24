<?php

class QueryBuilder{
	
	var $db;
	var $table;
	var $columns;
	var $columnsNames;
	var $filterData = array();
	var $limit = '';
	var $order = '';
	var $langID;
	var $lang;
	var $autoFillFields;
	
	function QueryBuilder($table){
		global $db;
		$this->db = $db;
		$this->table = $table;
		$this->getColumns();
	}
	
	function getColumns(){
		if ($this->table){
			$query = $this->db->prepare("SHOW COLUMNS FROM ".$this->table);
			$res = $this->db->Execute($query);
			if ($res && $res->RecordCount() > 0){
				$columns = $res->getArray();
				foreach ($columns as $key=>$val){
					$field = array_shift($columns[$key]);
					$this->columns[$field] = $columns[$key];
					$this->columnsNames[] = $field;
				}
			}
		}
	}
	
	function setLangID($langID){
		if (!empty($langID)){
			$this->langID = $langID;
			$this->setFilter('LangID', $langID);
		}
	}

	function setLang($lang){
		if (!empty($lang)){
			$this->setFilter('Lang', $lang);
		}
	}
	
	function setFilter($key, $value){
		if (in_array($key, $this->columnsNames)){
			$this->filterData[] = array(
					'field' => $key,
					'value' => $value
				);
		}
	}
	
	function setLimit($from, $count=0){
		$limit = '';
		if ($from){
			$limit = ' LIMIT '.$from;
		}
		if ($from && $count && $count!=0){
			$limit .= ', '.$count;
		}
		$this->limit = $limit;
	}
	
	function setOrder($field, $dest = 'ASC'){
		$order = '';
		if (in_array($field, $this->columnsNames)){
			if ($order){
				$order = ' ORDER BY '.$field;
			}
			if ($order && $dest){
				$order .= ' '.$dest;
			}
		}
		$this->order = $order;
	}
	
	function whereBuilder(){
		$where = '';
		$conditions = array();
		if (count($this->filterData) > 0){
			foreach ($this->filterData as $i=>$condition){
				//if (preg_match("/^[varchar|char|text|tinytext|longtext]+.*$/ui", $this->columns[$condition['field']]['Type'])){
				if (preg_match("/^[text|tinytext|longtext]+.*$/ui", $this->columns[$condition['field']]['Type'])){
					$conditions[] = $condition['field']." LIKE '%".$condition['value']."%'";
				} else {
					$conditions[] = $condition['field']."='".$condition['value']."'";
				}
			}
			$where = ' WHERE '.implode(' AND ', $conditions);
		}
		return $where;
	}
	
	function makeSelect($fieldNames=''){
		$fields = $this->columnsNames;
		if (!empty($fieldNames)){
			$fieldNames = trim($fieldNames);
			$fieldNames = preg_replace("/\s*/", "", $fieldNames);
			$fields = explode(",", $fieldNames);
		}
		
		$arr = array();
		
		$query = "SELECT ".implode(", ", $fields)." FROM ".$this->table."";
		$query .= $this->whereBuilder();
		$query .= $this->order;
		$query .= $this->limit;
		$query = $this->db->prepare($query);
        //die($query);
		$res = $this->db->Execute($query);
		if ($res && $res->RecordCount()){
			$arr = $res->getArray();
		}
		
		return $arr;
	}
	
	
	function setAutoFillFields($array){
		if (count($array)>0){
			$this->autoFillFields = $array;
		}
	}

	function getAutoFillFields(){
		$data = array();
		if (count($this->autoFillFields)>0){
			foreach ($this->autoFillFields as $key=>$value){
				$data[$key] = $value;
			}
		}
		return $data;
	}
	
	function makeInsert($data){
		$fields = $this->columnsNames;
		if (!empty($fieldNames)){
			$fieldNames = trim($fieldNames);
			$fieldNames = preg_replace("/\s*/", "", $fieldNames);
			$fields = explode(",", $fieldNames);
		}
		$idName = array_shift($fields);
		
		$keys = array();
		$values = array();
		
		if ($this->langID && !empty($this->langID)){
			$data['LangID'] = $this->langID;
		}
		
		$old_data = $data;
		$data = array();
		foreach ($old_data as $key=>$value){
			if (in_array($key, $fields)){
				$data[$key] = "'".mysql_real_escape_string($value)."'"; 
			}
		}
		
		
		$autofill = $this->getAutoFillFields();
		foreach ($autofill as $key=>$value){
			if ((!isset($data[$key]) || $data[$key]=="''") && in_array($key, $fields)){
				$data[$key] = $value; 
			}
		}
		
		foreach ($data as $key=>$value){
			$keys[] = $key;
			$values[] = $value;
		}
		
		
		$query = "INSERT INTO ".$this->table;
		$query .= "(`" . implode("`,`", $keys) . "`)";
		$query .= " VALUES(" . implode(",", $values) . ")";
		
		return $query;
	}
	
	function makeUpdate($data){
		$fields = $this->columnsNames;
		$idName = '';
		if (!empty($fieldNames)){
			$fieldNames = trim($fieldNames);
			$fieldNames = preg_replace("/\s*/", "", $fieldNames);
			$fields = explode(",", $fieldNames);
		}
		
		if ($this->langID && !empty($this->langID)){
			$data['LangID'] = $this->langID;
		}
		
		$idName = array_shift($fields);
		$idValue = '';
		$old_data = $data;
		$data = array();
		foreach ($old_data as $key=>$val){
			if ($key==$idName){
				$idValue = mysql_real_escape_string($val);
			} else {
				if (in_array($key, $fields)){
					$data[$key] = mysql_real_escape_string($val);
				}
			}
		}
		
		$preparedData = array();
		foreach ($data as $key=>$val){
			$preparedData[] = "`".$key."`='".$val."'";
		}
	
		$autofill = $this->getAutoFillFields();
		foreach ($autofill as $key=>$value){
			$preparedData[] = "`".$key."`=".$value."";
		}
		
		$query = "UPDATE ".$this->table." SET ";
		$query .= implode(", ", $preparedData);
		$query .= " WHERE `".$idName."`=".$idValue;
		
		return $query;
	}
	
	function makeDelete($ids){
		$fields = $this->columnsNames;
		$idName = '';
		if (!empty($fieldNames)){
			$fieldNames = trim($fieldNames);
			$fieldNames = preg_replace("/\s*/", "", $fieldNames);
			$fields = explode(",", $fieldNames);
		}
		
		$idName = array_shift($fields);

		if (strpos($ids,',')===false){
			$ids = array($ids);
		} else {
			$ids = preg_replace("/\s+/", "", $ids);
			$ids = explode(",", $ids);
		}
		if (is_array($ids) && count($ids) > 0){
			$query = "DELETE FROM ".$this->table."  ";
			$query .= " WHERE `".$idName."` IN ('".implode("','",$ids)."')";
		}
		
		return $query;
	}
	
}
?>