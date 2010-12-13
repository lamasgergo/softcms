<?php
require_once dirname(__FILE__).'/../../kernel/Base.php';


class TabElement extends Base{
	/* Name of a Tab Element */
	private $name;

	/* ADODB object */
	protected $db;

	/* Smarty object */
	protected $smarty;

	/* current language */
	protected $language;
    protected $allowedLanguages = array();

	/* user object */
	private $user;

    protected $gridFields = array();

    protected $requiredFields = array();

    protected $table;

    protected $whSkipParams = array('page', 'mod');

    public $moduleName;

    protected $templatePath;

	function __construct(){
        parent::__construct();
        $this->user = User::getInstance();
        if (empty($this->gridFields)){
            $this->gridFields = $this->fields;
        }

        $this->moduleName = $_GET[Settings::get('modules_varname')];
		$this->language = $this->user->get('EditLang');
        $this->allowedLanguages = Access::getAllowedLanguages($this->moduleName, 'show');

        $this->templatePath = realpath(dirname(__FILE__).'/../templates/admin/modules/');
        $this->smarty->addTemplateDir($this->templatePath);

        $this->setTemplateVars();
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
        $whereArr = array();
        if ($this->dependsOnType){
            $whereArr[] = "`Type`='{$this->type}'";
        }
        if ($this->id){
            $whereArr[] = "`$this->primaryKey`='{$this->id}'";
            $this->paging = false;
        }
        if (!empty($this->allowedLanguages)){
            $langs = implode("','", $this->allowedLanguages);
            $whereArr[] = "lang IN ('{$langs}')";
        }

        return $whereArr;
    }

    function jqGridData(){
        $grid = clone $this;
        if (($perPage = (int)$_GET['rows'])){
            $grid->setPerPage($perPage);
        }

        $orderBy = $_GET['sidx'];
        $orderDest = $_GET['sord'];
        if (!empty($orderBy)){
            $grid->setOrder($orderBy, $orderDest);
        }

        $rows = $grid->getData('', $grid->gridFields);
        foreach ($rows as $i=>$row){
            $responce->rows[$i]['cell'] = array_values($row);
            $responce->rows[$i]['id'] = array_shift($row);
        }
        $responce->page = $grid->getCurrentPage();
        $responce->total = ceil($grid->totalRecords / $grid->perPage);
        $responce->records = $grid->totalRecords;
        return $responce;
    }

    function prepareFormData($id=''){}

    function formData($id=""){
        $this->prepareFormData($id);
        if (!empty($id)){
            $this->id = $id;
			$query = $this->getQuery();
			$rs = $this->db->Execute($query);
			if ($rs && $rs->RecordCount() > 0){

				$values = $rs->GetArray();
				$this->smarty->assign("items_arr",$values);

			} else $this->smarty->assign("items_arr",array());
		} else {
			$this->smarty->assign("items_arr",array());
			$this->smarty->assign("after_checked","checked");
		}
        $this->smarty->assign("debug", Log::getInstance()->get());
    }

    function showForm($form, $id = "") {
        $file = '';
        if (Access::check($this->moduleName, $form)) {
            $this->formData($id);
            $this->smarty->assign("required", implode(",", $this->requiredFields));
            $this->smarty->assign("form", $form);
            $this->setTemplateVars();
            $file = $this->smarty->fetch($this->templatePath . '/form.tpl', null, $this->language);
        }
        return $file;
    }

	function checkRequiredFields($data){
        $data = $this->prepareData($data);
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
                        if (isset($data[$field])){
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
		}
		return true;
	}

	function getOptions($query_str, $assign=''){
        $results = array();
	    if (!empty($query_str) && !empty($assign)){
    		$query = $this->db->Prepare($query_str);
    		$res = $this->db->Execute($query);
    		if ($res && $res->RecordCount() > 0){
    			while (!$res->EOF){
                    $keys = array_keys($res->fields);
                    if(count($keys)>=2){
                        $results[$res->fields[$keys[0]]] = $res->fields[$keys[1]];
                    } else {
                        $results[$res->fields[$keys[0]]] = $res->fields[$keys[0]];
                    }
                    $res->MoveNext();
                }
    		}
	    }
        $this->smarty->assign($assign, $results);
	}

    function prepareData($data){

        if (!isset($data['Published']) && in_array('Published', $this->fields)){
            $data['Published'] = 0;
        }
        if (!isset($data['UserID']) && in_array('UserID', $this->fields)){
            $data['UserID'] = $this->user->get('ID');
        }
        if (!isset($data['Type']) && in_array('Type', $this->fields)){
            $data['Type'] = $this->type;
        }
        if (!isset($data['Lang']) && in_array('Lang', $this->fields)){
            $data['Lang'] = $this->language;
        }
        $values = array();
        foreach ($this->fields as $field){
            if (isset($data[$field])){
                $value = trim($data[$field]);
                if (strtolower($field)=='id'){
                    if ($value!=''){
                        $values[$field] = mysql_real_escape_string($value);
                    }
                } else {
                    if ($value != ''){
                        $values[$field] = mysql_real_escape_string($value);
                    }
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
        $query = "SELECT ID, Name FROM `{$this->table}` WHERE Type='{$this->type}' AND ParentID='{$parent_id}' AND Lang='{$this->language}' ORDER BY ID";
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
        return $this->getData();
    }

    function getGridFields(){
        return $this->gridFields;
    }

    function prepareConditions($cond=array()){
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
