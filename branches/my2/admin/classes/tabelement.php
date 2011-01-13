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

	/* user object */
	private $user;

    protected $gridFields = array();

    protected $requiredFields = array();

    protected $table;

    protected $whSkipParams = array('page', 'mod');

    public $moduleName;

    protected $templatePath;
    protected $tableTemplate = 'table.tpl';
    protected $formTemplate = 'form.tpl';

	function __construct(){
        parent::__construct();
        $this->user = User::getInstance();
        if (empty($this->gridFields)){
            $this->gridFields = $this->fields;
        }

        $this->moduleName = $_GET[Settings::get('modules_varname')];
		$this->language = $this->user->get('EditLang');

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

    function formData($id="", $action=''){
        $this->prepareFormData($id, $action);
        if (!empty($id)){
            $this->id = $id;
			$query = $this->getQuery();
			$rs = $this->db->Execute($query);
            $types = array();
			if ($rs && $rs->RecordCount() > 0){
                while (!$rs->EOF){
                    if (empty($types)){
                        for ($i=0; $i<$rs->FieldCount(); $i++){
                            $field = $rs->FetchField($i);
                            $types[$field->name] = $rs->MetaType($field);
                        }
                    }
				    $values[] = $rs->fields;
                    $rs->MoveNext();
                }
				$this->smarty->assign("items_arr", $values);
				$this->smarty->assign("field_types", htmlspecialchars(json_encode($types)));

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
            $this->formData($id,$form);
            $this->smarty->assign("required", implode(",", $this->requiredFields));
            $this->smarty->assign("form", $form);
            $this->setTemplateVars();
            $file = $this->smarty->fetch($this->formTemplate, null, $this->language);
        }
        return $file;
    }

    function checkByTypes($data){
        $field_types = json_decode(stripslashes($data["FieldsInfo"]));
        if (is_array($field_types)){
            foreach ($field_types as $i=>$item){

            }
        }
    }

	function checkRequiredFields($data){
        $data = $this->prepareData($data);
		if (isset($data["RequiredFields"]) && !empty($data["RequiredFields"])){
			$data["RequiredFields"] = preg_replace("/\s+/", "", $data["RequiredFields"]);
            if (isset($data["FieldsInfo"]) && !empty($data["FieldsInfo"])){
                return $this->checkByTypes($data);
            }
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

        foreach ($data as $name=>$value){
            if (isset($data[$name]) && !is_array($data[$name])){
                $value = trim($value);
                if (strtolower($name)=='id'){
                    if ($value!=''){
                        $data[$name] = mysql_real_escape_string($value);
                    }
                } else {
                    if ($value != ''){
                        $data[$name] = mysql_real_escape_string($value);
                    }
                }
            }
        }
        return $data;
    }

    function add($data){
        $data = $this->prepareData($data);
        $query = $this->db->GetInsertSQL();
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
