<form id="EXForm" onsubmit="return false;"><input type="hidden"	id="RequiredFields" name="RequiredFields" value="Name">
<table border="0" cellpadding="5" cellspacing="0" class="content"
	width="100%" height="100%" bgcolor="white">
	<tr valign="top">
		<td>
		<table border="0" cellpadding="5" cellspacing="0" class="content">
			<!--
			<tr>
				<td>{$module|cat:"_LangID"|lang}<span class="required">*</span></td>
				<td>
					<select name="LangID" id="LangID" onChange="categories_showCategories(this.value, document.getElementById('ID').value);">
						<option value="0">{lang select_default_name}</option>
						{html_options values=$lang_ids selected=$items_arr[0].LangID output=$lang_names}
					</select>
				</td>
			</tr>
			-->
			<tr>
				<td>{$module|cat:"_parent"|lang}</td>
				<td>
					<select name="ParentID" id="ParentID">
						<option value="0">{lang select_default_name}</option>
						{html_options values=$parent_ids selected=$items_arr[0].ParentID output=$parent_names}
					</select>
				</td>
			</tr>
			<tr>
				<td>{$module|cat:"_name"|lang}<span class="required">*</span></td>
				<td><input type="text" id="Name" name="Name" value="{$items_arr[0].Name}" class="form_item"></td>
			</tr>
			<tr>
				<td>{$module|cat:"_description"|lang}</td>
				<td><textarea id="Description" name="Description" class="form_area">{$items_arr[0].Description}</textarea></td>
			</tr>
			<tr>
				<td>{$module|cat:"_published"|lang}</td>
				<td>
					{if $items_arr[0].Published eq "1"}{assign var="pub_ch" value="checked"}{else}{assign var="pub_ch" value=""}{/if}
					<input type="checkbox" id="Published" name="Published" value="1" {$pub_ch}>
				</td>
			</tr>
			<tr>
				<td>{$module|cat:"_AllowComments"|lang}</td>
				<td>
					{if $items_arr[0].AllowComments eq "1"}{assign var="AllowComments_ch" value="checked"}{else}{assign var="AllowComments_ch" value=""}{/if}
					<input type="checkbox" id="AllowComments" name="AllowComments" value="1" {$AllowComments_ch}>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr valign="bottom">
		<td align="right">
			<input type="hidden" id="ID" name="ID" value="{$items_arr[0].ID}">
			<input type="hidden" id="tab_name" name="tab_name" value="{$tab_name}">
            {if $form=='change'}
				<input type="submit" name="{$module}_apply" value="{'button_apply'|lang}" class="form_but" onclick="send_form('EXForm', '{$module}', '{$component}', '{$component}_{$form}', true); return false;">
			{/if}
			<input type="submit" name="{$module}_vendors" value="{'button_'|cat:$form|lang}" class="form_but" onclick="send_form('EXForm', '{$module}', '{$component}', '{$component}_{$form}'); return false;">
		</td>
	</tr>
</table>
</form>
