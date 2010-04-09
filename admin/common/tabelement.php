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
    private $type;

    private $fields = array();

    private $requiredFields = array();

    private $table;

    public $moduleName;

    protected $templatePath;
	
	function __construct(){

        $obReg = ObjectRegistry::getInstance();
		$this->user = $obReg->get('user');
		$this->smarty = $obReg->get('smarty');
		$this->db = $obReg->get('db');

        $this->moduleName = $this->getName();
		$this->language = $this->user->get('EditLang');
        $this->setTemplateVars();
	}

    function getName() {
        return strtolower(__CLASS__);
    }

    function getValue(){}

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

	function getOptions($sql_str, $sql_fields=array(), $assign=array()){
	    $ids = array();
		$names = array();
	    if (!empty($sql_str) && count($assign)!=0 && count($sql_fields)!=0){
    		$sql = $this->db->Prepare($sql_str);
    		$res = $this->db->Execute($sql);
    		if ($res && $res->RecordCount() > 0){
    			while (!$res->EOF){
    				$ids[] = $res->fields[$sql_fields[0]];
    				$names[] = $res->fields[$sql_fields[1]];
    				$res->MoveNext();
    			}
    		}
	    }
	    $this->smarty->assign($assign[0],$ids);
    	$this->smarty->assign($assign[1],$names);
	}

    function prepareData($data){
        if (!isset($data['Published'])) $data['Published'] = 0;
        $data['UserID'] = $this->user->id;
        $data['Type'] = $this->type;
        $data['Lang'] = $this->language;
        $values = array();
        foreach ($this->fields as $item){
            if ($item=='ID'){
                if (!empty($data[$item])) $values[$item] = mysql_real_escape_string($data[$item]);
            } else $values[$item] = mysql_real_escape_string($data[$item]);
        }
        return $values;
    }

    function add($data){
        $data = $this->prepareData($data);
        $sql = $this->db->prepare("INSERT INTO " . $this->table . "(
            `" . implode('`,`', array_keys($data)) . "`
            ) VALUES (
            '" . implode("','", array_values($data)) . "'
            )");
        if ($this->db->Execute($sql)) return true;
        return false;
    }

    function change($data){
        $data = $this->prepareData($data);
        $upd = array();
        foreach ($data as $field=>$value){
            $upd[] = "`".$field."` = '".$value."'";
        }
        $sql = $this->db->prepare("UPDATE " . $this->table . " SET ".implode(",", $upd)." WHERE ID='".$data['ID']."'");
        if ($this->db->Execute($sql)) return true;
        return false;
    }

    function delete($ids){
        if (!is_array($ids) && preg_match("/[\d\,\s]+/", $ids)) $ids = explode(',', $ids);
        $ids = array_unique($ids);

        if (count($ids) <= 0) return array();

        $sql = $this->db->prepare("DELETE FROM " . $this->table . " WHERE id IN ('" . implode("','", $ids) . "')");
        $res = $this->db->Execute($sql);
        if ($res){
            return $ids;
        } else return array();
    }

    function deleteRecursive($data){
        $ids = explode(',', $data['ids']);
        $ids = array_unique($ids);

        if (count($ids) <= 0) return array();
        
        $delete = array();
        foreach ($ids as $id) {
            $delete[] = array('id' => $id);
            $delete = array_merge_recursive($this->getTreeListByParent($id), $delete);
        }
        $ids = array();
        foreach($delete as $item){
            $ids[] = $item['id'];
        }
        return $this->delete($ids);
    }

    function setType($type){
        $this->type = $type;
    }

    function getTreeListByParent($parent_id = 0, $ret = array(), $depth = 0) {
        if (isset($this->fields) && !in_array('ParentID', $this->fields)) return array();

        $depth++;
        $sql = "SELECT ID, Name FROM {$this->table} WHERE ParentID='{$parent_id}' AND Lang='{$this->language}' ORDER BY ID";
        $res = $this->db->Execute($sql);
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
}
?>
