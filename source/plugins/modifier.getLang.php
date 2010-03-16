<?
function smarty_modifier_getLang($id)
{
  global $langService;
  return $langService->getLanguageById($id);
}
?>