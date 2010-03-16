<?php

class Page{

	var $db;
	var $smarty;
	var $language;
	var $lang;
	var $langID;

	var $blocks;
	var $block_vars;
	var $blockID;
	var $dynamic_body;
	var $module;
	var $xajax;

	var $template;

	var $design;

	var $path;
	
	var $tpl;


	function Page($module=null){
		global $db,$smarty,$language,$lang,$LangID,$xajax;
		$this->db = &$db;
		$this->smarty = &$smarty;
		$this->language = &$language;
		$this->lang = $lang;
		$this->langID = &$LangID;
		$this->xajax = &$xajax;

		if ($module!=null){
			if ($this->checkModuleExists($module)){
				$this->module = $module;
			}
			$this->dynamic_body = true;
		} else {
			$this->dynamic_body = false;	
		}
		$this->blockID = $this->getModuleDefault($module);
		
		if (empty($this->design)){
			$this->design = 'default';
			$this->tpl = 'index.tpl';
		}
		if (empty($this->path)){
			$this->path = TEMPLATES."/design/".$this->design;
		}
		$this->smarty->assign("design_images",DESIGN_IMAGES_DIR.'/'.$this->design."/images");
		$this->smarty->assign("design_css",DESIGN_IMAGES_DIR.'/'.$this->design."/css");
		$this->smarty->assign("design_js",DESIGN_IMAGES_DIR.'/'.$this->design."/js");		
		$this->smarty->template_dir = $this->path;

		$this->loadBlocks();
	}
	
	
	function checkBlockForModule($module){
		$sql = $this->db->prepare("SELECT ID FROM ".DB_PREFIX."blocks WHERE ModuleSpec='".$module."' AND Module_default='yes'");
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			return true;
		} else {
			return false;
		}
	}
	
	function getModuleDefault($module=null){
		if ($module!=null && $this->checkBlockForModule($module)){
			$sql = $this->db->prepare("SELECT b.ID as ID, b.Name as Name, d.Name as Design, d.Tpl as Tpl FROM ".DB_PREFIX."blocks as b LEFT JOIN ".DB_PREFIX."design as d ON (d.ID=b.DesignID) WHERE b.ModuleSpec='".$module."' AND b.Module_default='yes' AND b.LangID='".$this->langID."'");
		} else {
			$sql = $this->db->prepare("SELECT b.ID as ID, b.Name as Name, d.Name as Design, d.Tpl as Tpl FROM ".DB_PREFIX."blocks as b LEFT JOIN ".DB_PREFIX."design as d ON (d.ID=b.DesignID) WHERE (b.ModuleSpec IS NULL OR b.ModuleSpec='') AND b.Module_default='yes' AND b.LangID='".$this->langID."'");
		}
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			$this->design = $res->fields["Design"];
			$this->path = TEMPLATES."/design/".$this->design;
			$this->tpl = $res->fields["Tpl"];
			return $res->fields["ID"];
		}
	}
	
	function loadBlocks(){
		$tpl_file = $this->path.'/index.tpl';
		$tpl = fopen($tpl_file,'rb');
		$tpl_source = fread($tpl,filesize($tpl_file));
		fclose($tpl);
		$blocks = array();
		preg_match_all("/\{[$]{1}([\d\w\_\-]+)\}/si",$tpl_source,$vars);
		if (count($vars[1]) > 0){
			for ($i=0;$i<count($vars[1]);$i++) {
				if ($vars[1][$i]){
					array_push($blocks,$vars[1][$i]);
				}
			}
		}
		$this->blocks = $blocks;
	}
	
	function checkMenuModules(){
		$menuId = intval($_GET['menuId']);
		if (isset($menuId) && !empty($menuId)){
			$sql = $this->db->prepare("SELECT ID FROM ".DB_PREFIX."blocks WHERE MenuID='".$menuId."'");
			$res = $this->db->Execute($sql);
			if ($res && $res->RecordCount() > 0){
				$this->blockID = $res->fields['ID'];
			}
		}	
		return false;
	}

	function setModules($menuID=0){
		if (!empty($this->blockID)){
			$sql = $this->db->prepare("SELECT Module,Params,BlockName,BlockOrder FROM ".DB_PREFIX."blocks_vars WHERE BlocksID='".$this->blockID."' ORDER BY BlockOrder");
			$res = $this->db->Execute($sql);
			if ($res && $res->RecordCount() > 0){
				while (!$res->EOF){
					if ($this->module!=null && $res->fields["BlockName"]=="BODY"){
						if ($res->fields['BlockOrder']==0){
							$this->block_vars[] = array(
								"block"		=> $res->fields["BlockName"],
								"module"	=> $this->module,
								"params"	=> '',
								"order"		=> ''
							);
						}
					} else {
						$this->block_vars[] = array(
							"block"		=> $res->fields["BlockName"],
							"module"	=> $res->fields["Module"],
							"params"	=> $res->fields["Params"],
							"order"		=> $res->fields["BlockOrder"]
						);
					}
					$res->MoveNext();
				}
			}
		}
	}
	
	function checkModuleExists($module){
		if (file_exists(MODULES_DIR.'/'.$module."/".$module.".php")){
			return true;
		} else return false;
	}
	
	function parse_vars(){
		$this->checkMenuModules();
		$this->setModules();
		
		
		$blocks = array();
		if (count($this->block_vars) > 0){
			foreach ($this->block_vars as $block){
				$output='';
				$block_vars = array();
				if (in_array($block["block"],$this->blocks)){
					$block_vars = $this->getModuleVars($block["params"]);
					if ($block["block"]=="BODY" && $this->dynamic_body){ 
						$dynamic = true;
					} else $dynamic = false;
					if ($this->checkModuleExists($block["module"])){
						include(MODULES_DIR.'/'.$block["module"]."/".$block["module"].".php");
					} 
					if (isset($blocks[$block["block"]])){
						$blocks[$block["block"]] .= $output;
					} else $blocks[$block["block"]] = $output;
				}
			}
		}
		foreach ($blocks as $block=>$output){
			$this->smarty->assign($block,$output);
		}
	}

	function getModuleVars($vars = ""){
		$vars = explode(",",$vars);
		$params = array();
		for ($i=0; $i < count($vars); $i++){
			if(!preg_match("/([\w\d\_\-]+)\=[\"\']+([^\"\']+)[\"\']+\s*/",$vars[$i],$var)){
				preg_match("/([\w\d\_\-]+)\=([\w\d\_\-]+)\s*/",$vars[$i],$var);
			}
			if (isset($var[1]) && isset($var[2])){
				$params[$var[1]] = $var[2];
			}
		}
		return $params;
	}
	
	function prepareOutput(){
		$this->parse_vars();
	}
	
	function show(){
		$this->smarty->display($this->tpl,null,$this->language);
	}
	
}
?>
