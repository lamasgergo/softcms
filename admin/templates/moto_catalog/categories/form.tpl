<form id="EXForm" onsubmit="return false;"><input type="hidden"	id="RequiredFields" name="RequiredFields" value="Name">
<table border="0" cellpadding="5" cellspacing="0" class="content"
	width="100%" height="100%" bgcolor="white">
	<tr valign="top">
		<td>
		<table border="0" cellpadding="5" cellspacing="0" class="content">
			<tr>
				<td>{$prefix|cat:"_parent"|lang}</td>
				<td>
					<select name="ParentID" id="ParentID">
						<option value="0">{lang select_default_name}</option>
						{html_options values=$parent_ids selected=$items_arr[0].ParentID output=$parent_names}
					</select>
				</td>
			</tr>
			<tr>
				<td>{$prefix|cat:"_name"|lang}<span class="required">*</span></td>
				<td><input type="text" id="Name" name="Name" value="{$items_arr[0].Name}" class="form_item"></td>
			</tr>
			<tr>
				<td>{$prefix|cat:"_description"|lang}</td>
				<td><textarea id="Description" name="Description" class="form_area">{$items_arr[0].Description}</textarea></td>
			</tr>
			<tr>
				<td>{$prefix|cat:"_published"|lang}</td>
				<td>
					{if $items_arr[0].Published eq "1"}{assign var="pub_ch" value="checked"}{else}{assign var="pub_ch" value=""}{/if}
					<input type="checkbox" id="Published" name="Published" value="1" {$pub_ch}>
				</td>
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
