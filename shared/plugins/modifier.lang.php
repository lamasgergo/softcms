<?
function smarty_modifier_lang($string)
{
	global $lang;
	return $lang->translate($string);
}
?>