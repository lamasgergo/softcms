<form id="EXForm" onsubmit="return false;">
<input type="hidden" id="RequiredFields" name="RequiredFields" value="Name,Description">
<table border="0" cellpadding="5" cellspacing="0" class="content" width="100%" height="100%" bgcolor="white">
  <tr valign="top">
    <td>
    <table border="0" cellpadding="5" cellspacing="0" class="content">
      <tr>
        <td>{$prefix|cat:"_name"|lang}<span class="required">*</span></td>
        <td>
        	<input type="text" id="Name" name="Name" value="{$items_arr[0].Name}" class="form_item">
			<input type="hidden" id="oldName" name="oldName" value="{$items_arr[0].Name}">
        	&nbsp; 
        	<select name="flags" id="flags" onchange="document.getElementById('Name').value=this.value;">
        	<option value="">{lang select_default_name}</option>
        	{foreach from=$flags_ids key=i item=flags_names}
        		<option name="{$flags_ids[$i]}" style="background: url({$flags_images[$i]}) no-repeat 80% 0%;">{$flags_ids[$i]}</option>
			{/foreach}
        	</select>
        </td>
      </tr>
      <tr>
        <td>{$prefix|cat:"_description"|lang}<span class="required">*</span></td>
        <td><input type="text" id="Description" name="Description" value="{$items_arr[0].Description}" class="form_item"></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr valign="bottom">
    <td align="right">
      <input type="hidden" id="ID" name="ID" value="{$items_arr[0].ID}">
      <input type="hidden" id="tab_name" name="tab_name" value="{$tab_name}">
      <input type="submit" name="{$prefix}_vendors" value="{'button_'|cat:$form|lang}" class="form_but" onclick="xajax_{$tab_prefix}_{$form}(xajax.getFormValues('EXForm')); return false;">
    </td>
  </tr>
</table>
</form>
