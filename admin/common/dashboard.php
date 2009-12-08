<?

  $sql = $db->prepare("SELECT ModGroup FROM ".DB_PREFIX."modules WHERE Active='1' GROUP BY ModGroup ORDER BY ID ASC");
  $res = $db->Execute($sql);
  $modules_groups = $res->getArray();
  $res->MoveFirst();
  $modules = array();
  if ($res && $res->RecordCount() > 0){
  	while (!$res->EOF){
	    $sql2 = $db->prepare("SELECT * FROM ".DB_PREFIX."modules WHERE ModGroup='".$res->fields["ModGroup"]."' AND Active='1' ORDER BY Name ASC");
		$res2 = $db->execute($sql2);
		if ($res2 && $res2->RecordCount() > 0){
			$data = $res2->GetArray();
	  		$modules[] = $data;
		} 
  		$res->MoveNext();
  		
  	}
  }
  

  $parse_main = $smarty->assign('modules_groups', $modules_groups);
  
  $smarty->assign("modules",$modules);
  
  
  $parse_main = $smarty->fetch('templates/dashboard/dashboard.tpl', null, $language);

?>