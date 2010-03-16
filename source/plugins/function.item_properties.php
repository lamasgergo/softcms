<?
function smarty_function_item_properties($params, &$smarty)
{
	$formitem  = "";
	$id = $params["id"];
	$count["form_count"] = 1;
	if (!empty($id)){
		$db = &$smarty->get_registered_object("db");
		$sql = $db->prepare("SELECT p.ID as ID, v.Value as Value, p.Name as Name, p.Type as Type, p.Required as Required, p.OrderNum as OrderNum FROM ".SDB_PREFIX."prop as p LEFT JOIN ".SDB_PREFIX."prop_values as v ON (v.PropID=p.ID) WHERE ItemID='".$id."' AND CategoryID IS NULL ORDER BY OrderNum ASC");
		$res = $db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			while (!$res->EOF){
				switch ($res->fields["Type"]){
					case "select":
						$formitem .= $res->fields["Name"]."<input type='hidden' name='form_item".$count["form_count"]."_name' id='form_item".$count["form_count"]."_name' value='".$res->fields["Name"]."'>";
						$formitem .= ":&nbsp;";
						$formitem .= "<select name='form_item".$count["form_count"]."' id='form_item".$count["form_count"]."' class='form_item'>\n";
						$formitem_hid = "";
						$opsql = $db->prepare("SELECT * FROM ".SDB_PREFIX."prop_options WHERE SelectID='".$res->fields["ID"]."' ORDER BY OrderNum ASC");
						$opres = $db->Execute($opsql);
						if ($opres && $opres->RecordCount() > 0){
							while (!$opres->EOF){
								if ($res->fields["Value"]==$opres->fields["Value"]){
									$formitem .= "<option value='".$opres->fields["Value"]."' selected>".$opres->fields["Name"]."</option>\n";
								} else {
									$formitem .= "<option value='".$opres->fields["Value"]."'>".$opres->fields["Name"]."</option>\n";
								}
								$opres->MoveNext();
							}
						}
						$formitem .= "</select>";
						$formitem .= $formitem_hid;
						$formitem .= "<br><br>";
						$count["select_count"]++;
						break;
					case "textarea":
						$formitem .= $res->fields["Name"]."<input type='hidden' name='form_item".$count["form_count"]."_name' id='form_item".$count["form_count"]."_name' value='".$res->fields["Name"]."'>";
						$formitem .= ":&nbsp;";
						$formitem .= "<textarea name='form_item".$count["form_count"]."' id='form_item".$count["form_count"]."' class='form_area'>".$res->fields["Value"]."</textarea><br>";
						$formitem .= "<br>";
						$count["text_count"]++;
						break;
					case "input_text":
						$formitem .= $res->fields["Name"]."<input type='hidden' name='form_item".$count["form_count"]."_name' id='form_item".$count["form_count"]."_name' value='".$res->fields["Name"]."'>";
						$formitem .= ":&nbsp;";
						$formitem .= "<input type='text' name='form_item".$count["form_count"]."' id='form_item".$count["form_count"]."' class='form_item' value='".$res->fields["Value"]."'><br>";
						$formitem .= "<br>";
						$count["inp_count"]++;
						break;
				}
				$res->MoveNext();
				$count["form_count"]++;
			}
		}
		unset($db);
	}
	return $formitem;
}

?>