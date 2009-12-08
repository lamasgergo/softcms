<form id="EXForm" onsubmit="return false;">
<table border="0" cellpadding="5" cellspacing="0" class="content"
	bgcolor="white">
	<tr valign="top">
		<td>
		<table border="0" cellpadding="5" cellspacing="0" class="content">
			<tr>
				<td>{$component|cat:"_ParentID"|lang}</td>
				<td>
					<select name="ParentID" id="ParentID">
						<option value="0">{lang select_default_name}</option>
						{html_options values=$parent_ids selected=$data.ParentID output=$parent_names}
					</select>
				</td>
			</tr>
			<tr>
				<td>{$component|cat:"_Name"|lang}<span class="required">*</span></td>
				<td><input type="text" id="Name" name="Name" value="{$data.Name}" class="form_item"></td>
			</tr>
			<tr>
				<td>{$component|cat:"_Description"|lang}</td>
				<td><textarea id="Description" name="Description" class="form_area">{$data.Description}</textarea></td>
			</tr>
			<tr>
				<td>{$component|cat:"_Published"|lang}</td>
				<td>
					{if $data.Published eq "1"}{assign var="pub_ch" value="checked"}{else}{assign var="pub_ch" value=""}{/if}
					<input type="checkbox" id="Published" name="Published" value="1" {$pub_ch}>
				</td>
			</tr>
			<tr>
				<td>{$component|cat:"_AllowComments"|lang}</td>
				<td>
					{if $data.AllowComments eq "1"}{assign var="AllowComments_ch" value="checked"}{else}{assign var="AllowComments_ch" value=""}{/if}
					<input type="checkbox" id="AllowComments" name="AllowComments" value="1" {$AllowComments_ch}>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr valign="bottom">
		<td align="right">
			<input type="hidden" id="ID" name="ID" value="{$data.ID}" class="form_item">
			{if $form=='change'}
				<input type="submit" name="{$component}_apply" value="{'button_apply'|lang}" class="form_but" onclick="xajax_{$component}_change(xajax.getFormValues('EXForm'), true); return false;">
			{/if}
			<input type="submit" name="{$component}_submit" value="{'button_'|cat:$form|lang}" class="form_but" onclick="xajax_{$component}_{$form}(xajax.getFormValues('EXForm')); return false;">
		</td>
	</tr>
</table>
</form>
