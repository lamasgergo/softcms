<?php
function smarty_modifier_lang($string){
	global $locale;
    
	return $locale->translate($string);
}
?>