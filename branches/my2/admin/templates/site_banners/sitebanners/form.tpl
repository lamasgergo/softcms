<form id="EXForm" onsubmit="return false;"><input type="hidden"
	id="RequiredFields" name="RequiredFields" value="Name,Del,DesignID,Module_default,LangID">
<table border="0" cellpadding="5" cellspacing="0" class="content"
	width="100%" height="100%" bgcolor="white">
	<tr valign="top">
		<td>
		<table border="0" cellpadding="5" cellspacing="0" class="content">
	      <tr>
	        <td>{$prefix|cat:"_groupid"|lang}<span class="required">*</span></td>
	        <td>
	                <select name="GroupID" id="GroupID" class="form_item">
	                  <option value="0">{lang select_default_name}</option>
	                  {html_options output=$GroupID_names values=$GroupID_ids selected=$items_arr[0].GroupID}
	                </select>
	        </td>
	      </tr>
	      <tr>
	        <td>{$prefix|cat:"_code"|lang}</td>
	        <td><textarea id="Code" name="Code" class="form_area">{$items_arr[0].Code}</textarea></td>
	      </tr>
	    </table>
		</td>
	</tr>
	<tr valign="bottom">
		<td align="right"><input type="hidden" id="ID" name="ID"
			value="{$items_arr[0].ID}"> <input type="hidden" id="tab_name"
			name="tab_name" value="{$tab_name}"> 
			<input type="hidden" id="tab_id" name="tab_id" value="{$tab_id}"> 
			<input type="submit"
			name="{$prefix}_vendors" value="{'button_'|cat:$form|lang}"
			class="form_but"
			onclick="{$tab_prefix}_{$form}(xajax.getFormValues('EXForm')); return false;">
		</td>
	</tr>
</table>
</form>
