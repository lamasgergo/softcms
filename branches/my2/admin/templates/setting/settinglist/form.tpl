<form id="EXForm" onsubmit="return false;">
<table border="0" cellpadding="5" cellspacing="0" class="content" width="100%" height="100%" bgcolor="white">
  <tr valign="top">
    <td>
    <table border="0" cellpadding="5" cellspacing="0" class="content">
      <tr>
        <td>{$prefix|cat:"_name"|lang}<span class="required">*</span></td>
        <td>
        	{if $form eq "add"}
        		<input type="text" id="Name" name="Name" value="{$items_arr[0].Name}" class="form_item">
        	{else}
        		<input type="text" id="Name" name="Name" value="{$items_arr[0].Name}" readonly class="form_item">
        	{/if}
        </td>
      </tr>
      <tr>
        <td>{$prefix|cat:"_value"|lang}<span class="required">*</span></td>
        <td><textarea id="Value" name="Value" class="form_area">{$items_arr[0].Value}</textarea></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr valign="bottom">
    <td align="right">
      <input type="hidden" id="ID" name="ID" value="{$items_arr[0].ID}">
      <input type="hidden" id="tab_name" name="tab_name" value="{$tab_name}">
      <input type="submit" name="{$prefix}_vendors" value="{'button_'|cat:$form|lang}" class="form_but" onclick="{$tab_prefix}_{$form}(xajax.getFormValues('EXForm')); return false;">
    </td>
  </tr>
</table>
</form>
