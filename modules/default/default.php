<?
  if ((!isset($_GET["mod"])) || (empty($_GET["mod"]) && $_GET["mod"]=="default")){
    
    $sql = $db->prepare("SELECT * FROM ".DB_PREFIX."pages WHERE name='DEFAULT' AND lang_id='".define_user_lang."' AND design_id='".define_users_tpl."'");
    $res = $db->Execute($sql);
    if ($res && $res->RecordCount() > 0){
      $smarty->assign("default",'{component name='.$res->fields["component"]." ".$res->fields["params"]." output=default}");
    } else{
      $smarty->assign("default",'');
    }
    $smarty->display('default/view1.tpl');
    print $smarty->_smarty_vars['capture']['source'];
  } else{
    $comp_params = "";
    foreach ($_GET as $key=>$val){
      if ($key=="alt"){
        $comp_name = $val;  
      } else{
        $comp_params .= $key."='".$val."' ";
      }
    }
    $smarty->assign("default",'{component name='.$comp_name." ".$comp_params." output=default}");
    $smarty->display('default/view1.tpl');
    print $smarty->_smarty_vars['capture']['source'];
  }
?>