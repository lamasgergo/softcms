<?
  $langid = $smarty->get_template_vars('LangID');
  $blockid = $smarty->get_template_vars('BlockID');
  $dynamic = false;
  if ((isset($_GET[MODULE]) && !empty($_GET[MODULE])) && (!isset($params['var']) || empty($params['var']))){
  $module = $_GET[MODULE];
  if (preg_match("/(\w+)\.(\w+)/",$_GET[MODULE],$om)){
    if ($om[1] && $om[2]){
      $module = $om[1];
      $module_file = $om[2];
    }
  } else {
    $module_file = $module; 
  }
  $dynamic = true;
  } else {
    $sql = $db->prepare("SELECT * FROM ".DB_PREFIX."blocks_vars WHERE BlocksID='".$blockid."' AND BlockName='".$params['var']."'");
    $res = $db->Execute($sql);
    if ($res && $res->RecordCount() > 0){
        $module = $res->fields["Module"];
        if (preg_match("/(\w+)\.(\w+)/",$res->fields["Module"],$om)){
          if ($om[1] && $om[2]){
            $module = $om[1];
            $module_file = $om[2];
          }
        } else {
          $module_file = $module;
        }
        $block_vars = array();
        preg_match_all("/(\w+)\=([\w\d]+)/si",$res->fields["Params"],$o);
        for ($i=0;$i<count($o[1]);$i++) {
          $block_vars[$o[1][$i]] = $o[2][$i];
        }
        
    }
  }
  if (file_exists(MODULES_DIR."/".$module."/".$module_file.".php")){
    include(MODULES_DIR."/".$module."/".$module_file.".php");
  }
  
  
  $smarty->assign("output",$output);
  echo $smarty->fetch("output/output.tpl",null,$language);
?>