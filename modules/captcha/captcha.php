<?php

header("Content-type: image/png");

if ($_GET['sid']) {
	/* define that the browser should treat
  	the output of this file as an image */
	
	// set the string to the key
	$string = $_GET['sid'];
	
	// create an temporary image from a PNG file
	$im = imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/source/images/captcha/bg.png");
	
	$black = imagecolorallocate($im, 0, 0, 0);
	
	$px = (imagesx($im) - 7.5 * strlen($string)) / 2;
	$h = (imagesy($im) - 7.5) / 2;
	
	#imagestring($im, 5, $px, $h, $string, $black);
	putenv('GDFONTPATH=' . realpath('.'));
	$font = 'VINERITC.TTF';
	#imagettftext($im, 20, 0, $px, $h, 20, $black, $font, $string);
	imagettftext($im, 20, 0, 5, 25, $black, $font, $string);
	
	echo $img = imagepng($im);
	
	imagedestroy($im);
	
}
?>