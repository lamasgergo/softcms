<?php
include_once (__LIBS__ . "/lib.upload.php");

class UploadBridge{
	
	var $name;
	var $user;
	var $smarty;
	var $xajax;
	var $db;
	var $lang;
	var $language;
	var $mod_name;
	var $tpl_module_path;
	var $uploadDirectory;
	var $tmpUploadDirectory;
	var $relativePath;
	
	var $moduleName; // upload for this module
	//image resize options
	var $image_ratio_x;
	var $image_ratio_y;
	
	var $log = false;
	var $logFile;
	
	function UploadBridge($mod_name='upload_bridge'){
		global $smarty, $language, $lang, $xajax, $db, $user;
		
		$this->name = __CLASS__;
		
		$this->user = $user;
		$this->smarty = &$smarty;
		$this->xajax = &$xajax;
		$this->db = &$db;
		$this->lang = $lang;
		$this->language = $language;
		//set common module name
		$this->mod_name = $mod_name;
		//set path to tab module templates
		$this->tpl_module_path = strtolower($this->mod_name);
		// set directory for image upload
		$this->uploadDirectory = uploadDirectory;
		// folder where will upload all module files
		$this->tmpUploadDirectory = tmpuploadDirectory;
		// set url to uploaded images
		$this->relativePath = uploadDirectoryURL;
		
		$this->xajax->registerFunction(array('add_upload_field', $this, 'add_upload_field'));
		
		$this->setResizeOptions();
		
		$this->log = false;
		$this->logFile = $this->tmpUploadDirectory . 'log.txt';
	}
	
	function setModuleName($mod){
		$mod = strval($mod);
		$this->moduleName = $mod;
	}
	
	function setResizeOptions(){
		if (image_resize_y == 0) {
			$this->image_ratio_x = false;
			$this->image_ratio_y = true;
		}
		if (image_resize_x == 0) {
			$this->image_ratio_y = false;
			$this->image_ratio_x = true;
		}
	}
	
	function processUpload(){
		if (isset($_POST['uploadimg'])) {
			$this->uploadFiles();
		} else {
			$this->deleteTemporaryFiles();
		}
	}
	
	function js_error($msg){
		if (! empty($msg)) {
			echo "<script language='Javascript'>" . $msg . "</script>";
		}
	}
	
	function uploadFiles(){
		if (! file_exists($this->tmpUploadDirectory)) {
			if (! mkdir($this->tmpUploadDirectory, 0777)) {
				return false;
			}
		}
		
		foreach ( $_FILES as $key => $val ) {
			if (preg_match("/^(file\d+)$/", $key, $mfile)) {
				if (isset($mfile[1]) && $_FILES[$mfile[1]]["size"] > 0) {
					$real_foto = "";
					$resize_foto = "";
					$name = $_FILES[$mfile[1]]["name"];
					$foto = new Upload($_FILES[$mfile[1]]);
					if ($foto->uploaded) {
						/**RESIZE**/
						if (image_resize==true){
							$foto->image_convert = image_convert_to;
							$foto->image_x = image_resize_x;
							$foto->image_y = image_resize_y;
							$foto->image_ratio_x = $this->image_ratio_x;
							$foto->image_ratio_y = $this->image_ratio_y;
							$foto->image_resize = true;
							$foto->force_rename = true;
							$foto->Process($this->tmpUploadDirectory);
							$resize_foto = $foto->file_dst_name;
							if ($foto->processed) {
								chmod($this->tmpUploadDirectory . $resize_foto, 0777);
							}
							if ($this->log && $handle = fopen($this->logFile, 'a')) {
								fwrite($handle, $foto->log . "\n");
								fclose($handle);
							}
						} else $resize_foto = '';
						
						/**REAL FOTO**/
						$foto->image_resize = false;
						$foto->force_rename = true;
						$foto->Process($this->tmpUploadDirectory);
						$real_foto = $foto->file_dst_name;
						/*************/
						if ($foto->processed) {
							chmod($this->tmpUploadDirectory . $real_foto, 0777);
						}
						
					} else {
						$this->js_error($this->lang["upl_error"] . $foto->error);
					}
					if (! empty($real_foto)) {
						$sql = $this->db->prepare("INSERT INTO " . DB_PREFIX . "upload_bridge(UserID,Name,File,ImageResize, Module) VALUES('" . $this->user->id . "','" . $name . "','" . $real_foto . "','" . $resize_foto . "', '".$this->moduleName."')");
						$this->db->Execute($sql);
					}
					
					if ($this->log && $handle = fopen($this->logFile, 'a')) {
						fwrite($handle, $foto->log . "\n");
						fclose($handle);
					}
				}
			}
		}
		echo "<script language='Javascript'>window.close();opener.window.focus();</script>";
	}
	
	function deleteTemporaryFiles(){
		$sql = $this->db->prepare("SELECT * FROM " . DB_PREFIX . "upload_bridge WHERE UserID='" . $this->user->id . "' AND Module='" . $this->moduleName . "'");
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0) {
			while ( ! $res->EOF ) {
				@unlink($this->tmpUploadDirectory . $res->fields["File"]);
				@unlink($this->tmpUploadDirectory . $res->fields["ImageResize"]);
				$this->db->Execute("DELETE FROM " . DB_PREFIX . "upload_bridge WHERE ID='" . $res->fields["ID"] . "'");
				$res->MoveNext();
			}
		}
	}
	
	function add_upload_field(){
		$objResponse = new xajaxResponse();
		$add_more = isset($this->lang["upl_add_more"]) ? $this->lang["upl_add_more"] : 'Add more';
		$src = '
			<div id="file_2" style="padding:5px;">
				<input type="file" name="file' . ($id + 1) . '" id="file' . ($id + 1) . '" class="form_item"><br><br>
				<span onclick="xajax_add_upload_field(document.getElementById(\'count\').value);" style="text-decoration:underline; cursor: hand;">' . $add_more . '</span>&nbsp;
			</div>
			<div id="file_' . ($id + 2) . '"></div>
		';
		$objResponse->addAssign('count', "value", $id + 1);
		$objResponse->addAppend('file_' . ($id + 1), "innerHTML", $src);
		return $objResponse->getXML();
	}
	
	function show(){
		return $this->smarty->fetch( $this->mod_name . '/main.tpl', null, $this->language);
	}
	
	function getUploadedFilesData(){
		$sql = $this->db->prepare("SELECT * FROM ".DB_PREFIX."upload_bridge WHERE UserID='".$this->user->edit_lang_id."' AND Module='".$this->moduleName."'");
		$res = $this->db->Execute($sql);
		if ($res && $res->RecordCount() > 0){
			list($files) = $res->getArray();
			$sql = $this->db->prepare("DELETE FROM ".DB_PREFIX."upload_bridge WHERE UserID='".$this->user->edit_lang_id."' AND Module='".$this->moduleName."'");
			$res = $this->db->Execute($sql);
			return $files;
		}
		return array();
	}
}

?>
