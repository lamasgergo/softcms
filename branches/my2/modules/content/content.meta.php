<?
$title = $lang["mod_content"];

if (isset($_GET["cid"]) && !empty($_GET["cid"]) && !isset($_GET["iid"])){
	$sql = $db->prepare("SELECT Name FROM ".DB_PREFIX."cnt_category WHERE ID='".$_GET["cid"]."'");
	$res = $db->Execute($sql);
	if ($res && $res->RecordCount() > 0){
		$title = $title." -> ".$res->fields["Name"];
	}
}

if (isset($_GET["cid"]) && !empty($_GET["cid"]) && isset($_GET["iid"]) && !empty($_GET["iid"])){
	$sql = $db->prepare("SELECT Name FROM ".DB_PREFIX."cnt_category WHERE ID='".$_GET["cid"]."'");
	$res = $db->Execute($sql);
	if ($res && $res->RecordCount() > 0){
		$title = $title." -> ".$res->fields["Name"];
		$sql2 = $db->prepare("SELECT Title,MetaTitle,MetaDescription,MetaKeywords,MetaAlt FROM ".DB_PREFIX."cnt_item WHERE ID='".$_GET["iid"]."'");
		$res2 = $db->Execute($sql2);
		if ($res2 && $res2->RecordCount() > 0){
			$title .= " -> ".$res2->fields["Title"];
			if (!empty($res2->fields["MetaTitle"])){
				$title = $res2->fields["MetaTitle"];
			}
			if (!empty($res2->fields["MetaDescription"])){
				$meta->meta_description = $res2->fields["MetaDescription"];
			}
			if (!empty($res2->fields["MetaKeywords"])){
				$meta->meta_keywords = $res2->fields["MetaKeywords"];
			}
			if (!empty($res2->fields["MetaAlt"])){
				$meta->meta_alt = $res2->fields["MetaAlt"];
			}
		}
	}
}

$meta->meta_title = $title;
?>