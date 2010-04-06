<?php
function smarty_modifier_lang($string)
{
  return Locale::get($string); 
}
?>