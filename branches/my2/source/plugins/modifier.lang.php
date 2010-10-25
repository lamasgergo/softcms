<?php
function smarty_modifier_lang($string, $context='')
{
  return Locale::get($string, $context);
}
?>