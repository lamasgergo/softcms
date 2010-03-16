<form id="EXForm" onsubmit="return false;" enctype="multipart/form-data">
<input type="hidden" id="RequiredFields" name="RequiredFields" value="Name, CategoryID, Image">
<table border="0" cellpadding="5" cellspacing="0" class="content"
	width="100%" height="100%" bgcolor="white">
	<tr valign="top">
		<td>
		<table border="0" cellpadding="5" cellspacing="0" class="content">
			<tr>
				<td>{$prefix|cat:"_parent"|lang}</td>
				<td>
				<table>
					<tr>
						<td><select name="ParentID" id="ParentID"
							onchange="{$tab_prefix}_show_menu_ordernum(this.value);">
							<option value="0">{lang select_default_name}</option>
							{html_options values=$parent_ids selected=$items_arr[0].ParentID
							output=$parent_names}
						</select></td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td>{$prefix|cat:"_name"|lang}<span class="required">*</span></td>
				<td><input type="text" id="Name" name="Name"
					value="{$items_arr[0].Name}" class="form_item"></td>
			</tr>
			<tr>
				<td>{$prefix|cat:"_description"|lang}<span class="required">*</span></td>
				<td>
					<textarea id="Description" name="Description" class="form_area">{$items_arr[0].Description}</textarea>
				</td>
			</tr>
			<tr>
				<td>{$prefix|cat:"_image"|lang}<span class="required">*</span></td>
				<td>
					<div id="fileupload">
		                <div id="uploaded_files" style="padding:3px;">{$uploaded_files}</div>
		                <div id="fileupload_files" style="clear:left;"></div>
		                <input readonly type="text" id="image1" name="image1" value="" class="form_item">
		                <input readonly type="hidden" id="ImageGroupID" name="ImageGroupID" value="{$items_arr[0].ImageGroupID}">
		                <input type="button" name="image1" value="{lang button_choose}" class="form_but" onclick="window.open('{mod_admin_link value=upload_manager}');">
              		</div>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr valign="bottom">
		<td align="right"><input type="hidden" id="ID" name="ID"
			value="{$items_arr[0].ID}"> <input type="hidden" id="tab_name"
			name="tab_name" value="{$tab_name}"> <input type="submit"
			name="{$prefix}_vendors" value="{'button_'|cat:$form|lang}"
			class="form_but"
			onclick="{$tab_prefix}_{$form}(xajax.getFormValues('EXForm')); return false;">
		</td>
	</tr>
</table>
</form>
