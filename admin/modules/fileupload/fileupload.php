<?
include_once (__LIBS__ . "/lib.upload.php");

$xajax->registerFunction ( "add_upload_field" );

$image_resize = image_resize;
$image_convert = image_convert_to;
$image_x = image_resize_x;
$image_y = image_resize_y;

if ($image_y == 0) {
	$image_ratio_x = false;
	$image_ratio_y = true;
}
if ($image_x == 0) {
	$image_ratio_y = false;
	$image_ratio_x = true;
}

$uploadDirectory = tmpuploadDirectory;
$logfilename = uploadDirectory . '/uploadlog.txt';

if (isset ( $_POST ["uploadimg"] )) {
	foreach ( $_FILES as $key => $val ) {
		if (preg_match ( "/(file\d+)/", $key, $mfile )) {
			if (isset ( $mfile [1] ) && $_FILES [$mfile [1]] ["size"] > 0) {
				$real_foto = "";
				$resize_foto = "";
				$name = $_FILES [$mfile [1]] ["name"];
				$foto = new Upload ( $_FILES [$mfile [1]] );
				if ($foto->uploaded) {
					/**RESIZE**/
					$foto->image_resize = $image_resize;
					$foto->image_convert = $image_convert;
					$foto->image_x = $image_x;
					$foto->image_y = $image_y;
					$foto->image_ratio_x = $image_ratio_x;
					$foto->image_ratio_y = $image_ratio_y;
					$foto->force_rename = true;
					if (! file_exists ( $uploadDirectory )) {
						if (! mkdir ( $uploadDirectory, 0777 )) {
							upl_error ( $lang ["upl_cant_make_tmp_dir"] );
						}
					}
					$foto->Process ( $uploadDirectory );
					$resize_foto = $foto->file_dst_name;
					/**REAL FOTO**/
					$foto->image_resize = false;
					$foto->force_rename = true;
					$foto->Process ( $uploadDirectory );
					$real_foto = $foto->file_dst_name;
					/*************/
					if (! $foto->processed) {
						upl_error ( $lang ["upl_error"] . $foto->error );
					}
					chmod ( $uploadDirectory . $real_foto, 0777 );
					chmod ( $uploadDirectory . $resize_foto, 0777 );
				} else {
					upl_error ( $lang ["upl_error"] . $foto->error );
				}
				if (! empty ( $real_foto )) {
					$sql = $db->prepare ( "INSERT INTO " . DB_PREFIX . "tmp_images(UserID,Name,Image,ImageResize) VALUES('" . $user->id . "','" . $name . "','" . $real_foto . "','" . $resize_foto . "')" );
					$db->execute ( $sql );
				}
				if (is_writable ( $logfilename )) {
					if ($handle = fopen ( $filename, 'a' )) {
						fwrite ( $handle, $foto->log . "\n" );
						fclose ( $handle );
					}
				}
			}
		}
	}
	echo "<script language='Javascript'>window.close();opener.window.focus();</script>";
} else {
	delete_tmp_files ();
}

if (isset($_GET['target']) && !empty($_GET['target'])){
	$smarty->assign('target', $_GET['target']);
} else {
	$smarty->assign('target', 'fileupload_files');
}

$parse_main = $smarty->fetch ( 'fileupload/fileupload.tpl', null, $language );

function getmicrotime() {
	
	$mtime = microtime ();
	$mtime = explode ( " ", $mtime );
	$mtime = $mtime [1] + $mtime [0];
	return ($mtime);

}

function upl_error($msg) {
	if (! empty ( $msg )) {
		echo "<script language='Javascript'>" . $msg . "</script>";
	}
}

function delete_tmp_files() {
	global $uploadDirectory, $db, $user;
	$sql = $db->prepare ( "SELECT * FROM " . DB_PREFIX . "tmp_images WHERE UserID='" . $user->id . "'" );
	$res = $db->execute ( $sql );
	if ($res && $res->RecordCount () > 0) {
		while ( ! $res->EOF ) {
			#try {
			@unlink ( $uploadDirectory . $res->fields ["Image"] );
			@unlink ( $uploadDirectory . $res->fields ["ImageResize"] );
			#} catch (Exception $e){
			

			#}
			$db->execute ( "DELETE FROM " . DB_PREFIX . "tmp_images WHERE ID='" . $res->fields ["ID"] . "'" );
			$res->MoveNext ();
		}
	}
}

function show_tmp_preview($id) {
	global $image_x, $image_y, $db;
	$src = "";
	$sql = $db->prepare ( "SELECT * FROM " . SDB_PREFIX . "images WHERE ID='" . $id . "'" );
	$res = $db->execute ( $sql );
	if ($res && $res->RecordCount () > 0) {
		$name = $res->fields ["Name"];
		$file_orig = $res->fields ["Image"];
		$file_resize = $res->fields ["ImageResize"];
		$shop_id = $res->fields ["ShopID"];
		if (! empty ( $file_resize ) && file_exists ( shopuploadDirectory . $shop_id . "/" . $file_resize )) {
			$src .= "<div style='padding:3px; float: left;' id='" . $name . "'>";
			$src .= "<img src='" . shopuploadDirectoryURL . $shop_id . "/" . $file_resize . "' border='0' title='" . $name . "' alt='" . $name . "' border='0'";
			if ($image_x != 0)
				$src .= " width='" . $image_x . "'";
			if ($image_y != 0)
				$src .= " height='" . $image_y . "'";
			$src .= ">";
			$src .= "<div>";
			if ($file_orig != "")
				$src .= "<a href='" . shopuploadDirectoryURL . $shop_id . "/" . $file_orig . "' target='preview'><img src='/source/images/fileupload/image_orig.gif' border='0' width='19'></a>";
			$src .= "<img src='/source/images/fileupload/image_del.gif' border='0' width='19' onclick='xajax_delete_image(\"" . $id . "\");'>";
			$src .= "</div>";
			$src .= "</div>";
		}
		;
		
		if (! empty ( $file_orig ) && ! file_exists ( shopuploadDirectory . $shop_id . "/" . $file_resize ) && file_exists ( shopuploadDirectory . $shop_id . "/" . $file_orig )) {
			$src .= "<div style='padding:3px; float: left;'>";
			$src .= "<img src='" . shopuploadDirectoryURL . "/" . $file_orig . "' border='0' title='" . $name . "' alt='" . $name . "' border='0'";
			if ($image_x != 0)
				$src .= " width='" . $image_x . "'";
			if ($image_y != 0)
				$src .= " height='" . $image_y . "'";
			$src .= ">";
			$src .= "<div style='border: 1px solid black;'>";
			$src .= "<img src='/source/images/fileupload/image_del.gif' border='0' width='19' onclick='xajax_delete_image(\"" . $id . "\");'>";
			$src .= "</div>";
			$src .= "</div>";
		}
	}
	return $src;
}

function add_upload_field($id) {
	global $lang;
	$objResponse = new xajaxResponse ( );
	$add_more = isset ( $lang ["upl_add_more"] ) ? $lang ["upl_add_more"] : 'Add more';
	$src = '
		<div id="file_2" style="padding:5px;">
			<input type="file" name="file' . ($id + 1) . '" id="file' . ($id + 1) . '" class="form_item"><br><br>
			<span onclick="xajax_add_upload_field(document.getElementById(\'count\').value);" style="text-decoration:underline; cursor: hand;">' . $add_more . '</span>&nbsp;
		</div>
		<div id="file_' . ($id + 2) . '"></div>
	';
	$objResponse->addAssign ( 'count', "value", $id + 1 );
	$objResponse->addAppend ( 'file_' . ($id + 1), "innerHTML", $src );
	return $objResponse->getXML ();
}
?>
