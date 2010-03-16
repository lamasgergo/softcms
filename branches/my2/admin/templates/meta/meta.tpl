<form id="EXForm" onsubmit="return false;">
<table border="0" cellpadding="5" cellspacing="0" class="content" bgcolor="white">
<tr valign="top">
  <td>
    <table border="0" cellpadding="5" cellspacing="0" class="content">
	{foreach from=$items item=item}    
    <tr>
      <td>{$item.MetaName|lang}<span class="required">*</span></td>
      <td><input type="text" id="{$item.MetaName}" name="{$item.MetaName}" value="{$item.MetaValue}" class="form_item"></td>
    </tr>
   	{/foreach}
	</table>
  </td>
</tr>
<tr valign="bottom">
  <td align="right">
    <input type="submit" name="save" value="{lang button_save}" class="form_but" onclick="save_meta(xajax.getFormValues('EXForm')); return false;">
  </td>
</tr>
</table>
</form>