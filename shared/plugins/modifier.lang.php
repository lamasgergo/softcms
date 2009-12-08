<?
function smarty_modifier_lang($string)
{
  global $lang;
  if (!isset($lang[$string])){
    return $string;
  } else return $lang[$string];
}
?>