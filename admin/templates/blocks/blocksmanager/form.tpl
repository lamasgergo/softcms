<form id="EXForm" onsubmit="return false;"><input type="hidden"
	id="RequiredFields" name="RequiredFields" value="Name,Del,DesignID,Module_default">
<table border="0" cellpadding="5" cellspacing="0" class="content"
	width="100%" height="100%" bgcolor="white">
	<tr valign="top">
		<td>
		<table border="0" cellpadding="5" cellspacing="0" class="content">
			<tr>
				<td>{$prefix|cat:"_name"|lang}<span class="required">*</span></td>
				<td><input type="text" id="Name" name="Name"
					value="{$items_arr[0].Name}" class="form_item"></td>
			</tr>
			<tr>
				<td>{$prefix|cat:"_menu"|lang}</td>
				<td>
				<table>
					<tr>
						<td><select name="MenuID" id="MenuID">
							<option value="0">{lang select_default_name}</option>
							{html_options values=$menu_ids selected=$items_arr[0].MenuID
							output=$menu_names}
						</select></td>
					</tr>
				</table>
				</td>
			</tr>
			<!-- 
			<tr>
				<td>{$prefix|cat:"_lang"|lang}<span class="required">*</span></td>
				<td>
				<table>
					<tr>
						<td><select name="LangID" id="LangID" onChange="blocksmanager_show_design(this.value);">
							<option value="0">{lang select_default_name}</option>
							{html_options values=$lang_ids selected=$items_arr[0].DesignID
							output=$lang_names}
						</select></td>
					</tr>
				</table>
				</td>
			</tr>
			 -->
			<tr>
				<td>{$prefix|cat:"_design"|lang}<span class="required">*</span></td>
				<td>
				<table>
					<tr>
						<td>
							<div id="DesignIDDiv">
								<select name="DesignID" id="DesignID">
									<option value="0">{lang select_default_name}</option>
									{html_options values=$design_ids selected=$items_arr[0].DesignID output=$design_names}
								</select>
							</div>
						</td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td>{$prefix|cat:"_module"|lang}</td>
				<td><input type="text" id="Module" name="Module"
					value="{$items_arr[0].Module}" class="form_item"></td>
			</tr>
			<tr>
				<td>{$prefix|cat:"_modulespec"|lang}</td>
				<td>
					<textarea id="ModuleSpec" name="ModuleSpec" class="form_area">{$items_arr[0].ModuleSpec}</textarea>
				</td>
			</tr>
			<tr>
				<td>{$prefix|cat:"_default"|lang}<span class="required">*</span></td>
				<td>
					{html_radios name="Module_default" values=$Module_default_ids selected=$items_arr[0].Module_default|default:'no' output=$Module_default_names separator="<br />"}
				</td>
			</tr>
			<tr>
				<td>{$prefix|cat:"_del"|lang}<span class="required">*</span></td>
				<td>
					{html_radios name="Del" values=$Del_ids selected=$items_arr[0].Del|default:'yes' output=$Del_names separator="<br />"}
				</td>
			</tr>
			<tr>
				<td>{$prefix|cat:"_getadd"|lang}</td>
				<td>
					<textarea id="GetAdd" name="GetAdd" class="form_area">{$items_arr[0].GetAdd}</textarea>
				</td>
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