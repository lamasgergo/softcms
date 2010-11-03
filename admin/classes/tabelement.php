<?php
interface ITabElement{
    function getValue();
    function formData($form, $id="");
    function getName();
}

class TabElement implements ITabElement{
	/* Name of a Tab Element */
	private $name;

	/* ADODB object */
	protected $db;

	/* Smarty object */
	protected $smarty;

	/* current language */
	protected $language;

	/* user object */
	private $user;

    /* data type*/
    protected $type;

    protected $fields = array();

    protected $gridFields = array();

    protected $requiredFields = array();

    protected $table;

    protected $whSkipParams = array('page', 'mod');

    public $moduleName;

    protected $templatePath;

    public $paging = true;
    public $perPage = 25;
    public $page = 0;
    public $totalRecords = 0;

	function __construct(){

        $obReg = ObjectRegistry::getInstance();
		$this->user = $obReg->get('user');
		$this->smarty = $obReg->get('smarty');
		$this->db = $obReg->get('db');

        if (empty($this->gridFields)){
            $this->gridFields = $this->fields;
        }

        $this->moduleName = $_GET[Settings::get('modules_varname')];
		$this->language = $this->user->get('EditLang');
        $this->setTemplateVars();
        $this->setNavigationVars();
	}

    //set common template privates
    function setTemplateVars() {
        $this->smarty->assign("module", $this->moduleName);
        $this->smarty->assign("component", $this->getName());
    }

    function getName() {
        return strtolower(__CLASS__);
    }

    function getConditions(){
        $where = '';
        $whereArr = array();
        if ($this->language){
            $whereArr[] = "lang='{$this->language}'";
        }
        if (count($whereArr) > 0){
            $where = " WHERE ".implode(" AND ", $whereArr);
        }
        return $where;
    }

    function getQuery(){
        $query = "SELECT ";
        if ($this->paging){
            $query .= "SQL_CALC_FOUND_ROWS ";
        }
        if (count($this->fields) > 0){
            $query .= '`'.implode('`,`', $this->fields).'`';
        } else{
            $query .= '*';
        }
        $query .= " FROM {$this->table} ";
        $query .= $this->getConditions();
        if ($this->paging){
            $startFrom = $this->page*$this->perPage;
            $query .= " LIMIT {$startFrom}, {$this->perPage}";
        }
        return $query;
    }

    function getValue(){
        $query = $this->getQuery();
        $query = $this->db->Prepare($query);
//echo $query."<br>";
	    $rs = $this->db->Execute($query);
        if ($this->paging){
            $totalQuery = $this->db->Prepare("SELECT FOUND_ROWS() as total");
            $totalRS = $this->db->Execute($totalQuery);
            if ($totalRS && $totalRS->RecordCount() > 0){
                $this->totalRecords = $totalRS->fields['total'];
            }
        }
	    if ($rs && $rs->RecordCount() > 0){
	        return $rs->GetArray();
	    } else {
	        return array();
	    }
    }

    function setNavigationVars(){
        if (isset($_GET['page'])){
            $this->setPage($_GET['page']);
        }
        if (isset($_GET['rows'])){
            $this->setPerPage($_GET['rows']);
        }
    }

    function setPage($page=0){
        $page = (int)$page;
        if ($page > 0){
            $this->page = $page - 1;
        } else {
            $this->page = 0;
        }

    }

    function setPerPage($perPage=0){
        $perPage = (int)$perPage;
        if ($perPage > 0){
            $this->perPage = $perPage;
        }

    }

    function getCurrentPage(){
        return $this->page + 1;
    }

    function jqGridData(){
        $rows = $this->getValue();
        foreach ($rows as $i=>$row){
            $responce->rows[$i]['cell'] = array_values($row);
            $responce->rows[$i]['id'] = array_shift($row);
        }
        $responce->page = $this->getCurrentPage();
        $responce->total = ceil($this->totalRecords / $this->perPage);
        $responce->records = $this->totalRecords;
        return $responce;
    }

    function formData($form,$id=""){}

    
	function checkRequiredFields($data){
		if (isset($data["RequiredFields"]) && !empty($data["RequiredFields"])){
			$data["RequiredFields"] = preg_replace("/\s+/", "", $data["RequiredFields"]);
			$fields = explode(",",$data["RequiredFields"]);
			if (is_array($fields)){
				if (count($fields) > 0){
					foreach ($fields as $field){
						/*
						$field = trim($field);
						if(!isset($data[$field])){
							return false;
						}
						*/
						if (is_array($data[$field])){
							if (!isset($data[$field][0])){
								return false;
							}
						} else {
							if (isset($data[$field])){
								if (is_numeric($data[$field]) && $data[$field]==0){
									return false;
								}
								if (is_string($data[$field]) && $data[$field]==''){
									return false;
								}
								/*
								if ($data[$field]=='' || $data[$field]==0){
									echo $field.' '.$data[$field];
									return false;
								}
								*/
							} else {
								print_r($data);
								echo $field.' '.$data[$field];
								return false;
							}
						}
					}
				}
			}
		}
		return true;
	}

	function getOptions($query_str, $query_fields=array(), $assign=array()){
	    $ids = array();
		$names = array();
	    if (!empty($query_str) && count($assign)!=0 && count($query_fields)!=0){
    		$query = $this->db->Prepare($query_str);
    		$res = $this->db->Execute($query);
    		if ($res && $res->RecordCount() > 0){
    			while (!$res->EOF){
    				$ids[] = $res->fields[$query_fields[0]];
    				$names[] = $res->fields[$query_fields[1]];
    				$res->MoveNext();
    			}
    		}
	    }
	    $this->smarty->assign($assign[0],$ids);
    	$this->smarty->assign($assign[1],$names);
	}

    function prepareData($data){
        if (!isset($data['Published'])) $data['Published'] = 0;
        $data['UserID'] = $this->user->get('ID');
        $data['Type'] = $this->type;
        $data['Lang'] = $this->language;
        $values = array();
        foreach ($this->fields as $item){
            if ($item=='ID'){
                if (!empty($data[$item])) $values[$item] = mysql_real_escape_string($data[$item]);
            } else {
				if (!empty($data[$item])){
					$values[$item] = mysql_real_escape_string($data[$item]);
				}
			}
        }
        return $values;
    }

    function add($data){
        $data = $this->prepareData($data);
        $query = $this->db->Prepare("INSERT INTO " . $this->table . "(
            `" . implode('`,`', array_keys($data)) . "`
            ) VALUES (
            '" . implode("','", array_values($data)) . "'
            )");
        if ($this->db->Execute($query)) return true;
        return false;
    }

    function change($data){
        $data = $this->prepareData($data);
        $upd = array();
        foreach ($data as $field=>$value){
            $upd[] = "`".$field."` = '".$value."'";
        }
        $query = $this->db->Prepare("UPDATE " . $this->table . " SET ".implode(",", $upd)." WHERE ID='".$data['ID']."'");
        if ($this->db->Execute($query)) return true;
        return false;
    }

    function delete($ids, $recursive = false){
        if (!is_array($ids) && preg_match("/[\d\,\s]+/", $ids)) $ids = explode(',', $ids);
        $ids = array_unique($ids);

        if (count($ids) <= 0) return array();
         
        if ($recursive==true){
            $delete = array();
            foreach ($ids as $id) {
                $delete[] = array('id' => $id);
                $delete = array_merge_recursive($this->getTreeListByParent($id), $delete);
            }
            $ids = array();
            foreach($delete as $item){
                $ids[] = $item['id'];
            }
            $ids = array_unique($ids);
        }

        
        $query = $this->db->Prepare("DELETE FROM {$this->table} WHERE id IN ('" . implode("','", $ids) . "')");
        $res = $this->db->Execute($query);
        if ($res){
            return $ids;
        } else return array();
    }


    function setType($type){
        $this->type = $type;
    }

    function getTreeListByParent($parent_id = 0, $ret = array(), $depth = 0) {
        if (isset($this->fields) && !in_array('ParentID', $this->fields)) return array();

        $depth++;
        $query = "SELECT ID, Name FROM `{$this->table}` WHERE ParentID='{$parent_id}' AND Lang='{$this->language}' ORDER BY ID";
        $res = $this->db->Execute($query);
        if ($res && $res->RecordCount() > 0) {
            while (!$res->EOF) {
                $depth_str = '';
                for ($i = 0; $i < $depth; $i++) $depth_str .= '-';
                $ret[] = array(
                    'id' => $res->fields["ID"],
                    'name' => $depth_str . $res->fields["Name"]
                );

                $ret = $this->getTreeListByParent($res->fields["ID"], $ret, $depth);
                $res->MoveNext();
            }
        }
        return $ret;
    }

    function getTabContent() {
        return $this->getValue();
    }

    function getGridFields(){
        return $this->gridFields;
    }

    function whCond($cond=array()){
        if (empty($cond)) $cond = $_GET;
        $wh = array();
        foreach ($cond as $key=>$value){
            if (!empty($value) && !in_array(strtolower($key), $this->whSkipParams)){
                foreach ($this->gridFields as $name){
                    if (strtolower($key)==strtolower($name)){
                        $wh[] = "`".$name."`='".mysql_real_escape_string($value)."'";
                    }
                }
            }
        }

        $wh = implode(' AND ', $wh);

        return $wh;
    }
}
?>
