<?php

$zip = new ZipArchive;
if ($zip->open('eqp_reliase.zip') === TRUE) {
    $zip->extractTo(dirname(__FILE__));
    $zip->close();
    echo 'ok';
} else {
    echo 'failed';
}

	
dirTree(dirname(__FILE__), 'eqp@eqp.com.ua');
	
	
function dirTree($dir, $user) {
	$d = dir($dir);
	while (false !== ($entry = $d->read())) {
	    if($entry != '.' && $entry != '..'){
			if (chmod($dir.'/'.$entry, 0777)){
				echo $dir.'/'.$entry.' - ok<br/>';
			} else {
				echo $dir.'/'.$entry.' - false<br/>';	
			}
			if (is_dir($dir.'/'.$entry)){
				dirTree($dir.'/'.$entry.'/',$user);
			}
	    }
	}
	$d->close();
	    
    return true;
	}
?> 