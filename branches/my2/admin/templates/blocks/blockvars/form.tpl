<form id="EXForm" onsubmit="return false;"><input type="hidden"
	id="RequiredFields" name="RequiredFields" value="BlocksID,Module,BlockName">
<table border="0" cellpadding="5" cellspacing="0" class="content"
	width="100%" height="100%" bgcolor="white">
	<tr valign="top">
		<td>
		<table border="0" cellpadding="5" cellspacing="0" class="content">
			<tr>
				<td>{$prefix|cat:"_BlocksID"|lang}<span class="required">*</span></td>
				<td>
				<table>
					<tr>
						<td>
						<select name="BlocksID" id="BlocksID" onChange="blockvars_showBlockNames(this.value);">
							<option value="0">{lang select_default_name}</option>
							{html_options values=$block_ids selected=$items_arr[0].BlocksID output=$block_names}
						</select></td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					{$modules}
				</td>
			</tr>
			<tr id="module_helper" style="display:none;">
				<td>{$prefix|cat:"_ModuleHelper"|lang}</td>
				<td id="module_helper_body"></td>
			</tr>
			<tr>
				<td>{$prefix|cat:"_Params"|lang}</td>
				<td><input type="text" id="Params" name="Params" class="form_item" value="{$items_arr[0].Params}"></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td id="ModuleParamsDiv"></td>
			</tr>
			<tr>
				<td>{$prefix|cat:"_BlockName"|lang}<span class="required">*</span></td>
				<td>
					<div id="BlockNameDiv">
	 					<select name="BlockName" id="BlockName" onChange="blockvars_showBlocksOrder(document.getElementById('BlocksID').options[document.getElementById('BlocksID').selectedIndex].value, this.value);">
							<option value="">{lang select_default_name}</option>
							{html_options values=$blockname_ids selected=$items_arr[0].BlockName output=$blockname_names}
						</select>
					</div>
				</td>
			</tr>
			<tr>
				<td>{$prefix|cat:"_BlockOrder"|lang}</td>
				<td>
					<table class="content">
					<tr>
						<td>
							<table class="content">
								<tr>
									<td><input type="radio" name="order" id="order" value="before"></td>
									<td>{$prefix|cat:"_order_before"|lang}</td>
								</tr>
								<tr valign="middle">
									<td><input type="radio" name="order" id="order" value="after"{$after_checked}></td>
									<td>{$prefix|cat:"_order_after"|lang}</td>
								</tr>
							</table>
						</td>
						<td>
							<div id="BlockOrderDiv">
								<select name="BlockOrder" id="BlockOrder">
									<option value="0">{lang select_default_name}</option>
									{html_options values=$blockorder_ids selected=$items_arr[0].BlockOrder output=$blockorder_names}
								</select>
							</div>
						</td>
					</tr>
					</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr valign="bottom">
		<td align="right">
			<input type="hidden" id="ID" name="ID" value="{$items_arr[0].ID}">
			<input type="hidden" id="tab_name" name="tab_name" value="{$tab_name}"> 
			<input type="hidden" id="tab_id" name="tab_id" value="{$tab_id}"> 
			<input type="submit" name="{$prefix}_vendors" value="{'button_'|cat:$form|lang}" class="form_but" onclick="{$tab_prefix}_{$form}(xajax.getFormValues('EXForm')); return false;">
		</td>
	</tr>
</table>
</form>

