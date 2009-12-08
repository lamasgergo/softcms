<?php

class BlocksHelper {
	
	
	function getModulesList(){
		// Modules
	    $modules_dir = realpath(dirname(__FILE__).'/blocks_modules/');
	    $modules_arr = array();
	    $dir = dir($modules_dir);
	    while (false !== ($entry = $dir->read())) {
	        if ($entry!='.' && $entry!='..'){
	        	$entry = preg_replace("/^(.+)\.php$/", "\\1", $entry);
               	$modules_arr[] = $entry;
	        }
        }
        return $modules_arr;
	}
	
	function getModulesListOptions($items_arr=array()){
		global $smarty, $language, $xajax;
		
	    $modules_arr = BlocksHelper::getModulesList();
	    $modules_names = array();
	    foreach ($modules_arr as $i=>$module){
        	if (isset($this->lang[$module])){
        		$modules_names[$i] = preg_replace("/\<br\s*\/?\>/", " ", $this->lang[$module]);
        	} else {
               	$modules_names[$i] = $module;
        	}
        }
        $smarty->assign('module_ids',$modules_arr);
    	$smarty->assign('module_names',$modules_names);

    	$smarty->assign('items_arr',$items_arr);
    	return $this->smarty->fetch('helpers/blocks.tpl',null,$language);
	}
	
	function BlocksModuleHelper($module){
		global $smarty;
		$objResponse = new xajaxResponse();

		if (!empty($module)){
			$modules_dir = realpath(dirname(__FILE__).'/blocks_modules/');
			$file = $modules_dir.'/'.$module.'.php';
			if (file_exists($file)){
				require_once $file;
				eval("\$form = ".ucfirst($module)."BlocksHelper::getForm();");
				$objResponse->addAssign("moduleForm","innerHTML",$form);
			}
		} else {
			$objResponse->addAssign("moduleForm","innerHTML",'');
		}
		return $objResponse->getXML();	
	}

	function ModuleHelperAddParam($params, $name, $value){
		global $smarty;
		$objResponse = new xajaxResponse();
		
		$new_params_arr = array();

		$found = false;
		
		if (!empty($params)){
		
			$params_arr = split(",", $params);
			
			foreach ($params_arr as $i=>$item){
				list($param_name, $param_value) = split("=", $item);
				if (trim($param_name)==trim($name)){
					if ($value!=''){
						$new_params_arr[$i] = $param_name.'='.trim($value);
					}
					$found = true;
				} else {
					$new_params_arr[$i] = $params_arr[$i];	
				}
			}
		}
		
		if ($found==false){
			if ($value!=''){
				$new_params_arr[] = trim($name).'='.trim($value);
			}	
		}
		$params = join(", ", $new_params_arr);
		
		$params = preg_replace("/\s+/", " ",$params);
		
		$objResponse->addAssign("Params", "value", $params);
		
		return $objResponse->getXML();	
	}
}

?>
