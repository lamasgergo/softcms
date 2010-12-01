<?php
class Base {

    protected $db;
    protected $smarty;
    protected $type = __CLASS__;
    protected $table;
    protected $fieldsOnly = false; //Use only $fields in query
    protected $fields = array();
    protected $joins = array();

    protected $primaryKey = 'ID';
    protected $id;

    public $data;

    protected $language;
    private $user;

    public $paging = true;
    public $perPage = 0;
    public $page = 0;
    public $totalRecords = 0;

    public $orderBy = 'ID';
    public $orderDest = 'DESC';

    public function __construct(){
        global $db, $smarty;

        $this->db = $db;
        $this->smarty = $smarty;
        $this->user = User::getInstance();
//        $this->type = $this->getName();

        $this->language = Settings::get('default_lang');
        $this->perPage = Settings::get('navigation_perPage');


        $this->templatePath = realpath(dirname(__FILE__)."/../design/{$this->getName()}/");

        $this->table = DB_PREFIX . 'data';
    }

    public function getName(){
        return strtolower($this->type);
    }

    public function getType(){
        return $this->type;
    }

    public function setID($id=''){
        $id = (int)$id;
        if (!empty($id)){
            $this->id = $id;
            $this->paging = false;
        }
    }

    function getConditions(){
        $whereArr = array();
        $whereArr[] = "`Type`='{$this->type}'";
        if ($this->id){
            $whereArr[] = "`$this->primaryKey`='{$this->id}'";
            $this->paging = false;
        }
        if ($this->language){
            $whereArr[] = "lang='{$this->language}'";
        }
        return $whereArr;
    }

    function getWhere(){
        $whereArr = $this->getConditions();
        if (count($whereArr) > 0){
            $where = " WHERE ".implode(" AND ", $whereArr);
        }
        return $where;
    }

    function getQuery($fields=''){
        $where = $this->getWhere();
        $query = "SELECT ";
        if ($this->paging){
            $query .= "SQL_CALC_FOUND_ROWS ";
        }
        if (!empty($fields)){
            if (is_array($fields)){
                $query .= '`'.implode('`,`', $fields).'`';
            } else {
                $query .= $fields;
            }
        } else {
            if ($this->fieldsOnly){
                $query .= '`'.implode('`,`', $this->fields).'`';
            } else{
                $query .= '*';
            }
        }
        $query .= " FROM {$this->table} ";
        if (count($this->joins) > 0){
            $query .= implode(' ', $this->joins);
        }
        $query .= $where;
        $query .= " ORDER BY ".$this->orderBy.' '.$this->orderDest;
        if ($this->paging){
            $startFrom = $this->page*$this->perPage;
            $query .= " LIMIT {$startFrom}, {$this->perPage}";
        }
//echo $query;
        return $query;
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

    function setOrder($field, $dest='ASC'){
        $this->orderBy = $field;
        $this->orderDest = $dest;
    }

    function getData($id='', $fields=''){
        $this->data = array();
        $id = (int)$id;
        if (!empty($id)) $this->setID($id);
        $query = $this->getQuery($fields);
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
            if (!empty($id)){
                $this->data = $rs->fields;
            } else {
                $this->data = $rs->GetArray();
            }

	    }
        return $this->data;
    }

}
?>