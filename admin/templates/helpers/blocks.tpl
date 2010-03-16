<div style="padding: 20px 0px;">
	<div style="float: left; padding: 5px 0px;">
		{"blocks_Module"|lang}<span class="required">*</span>:&nbsp;
	</div>
	<div style="float: left;  padding: 5px 0px;">
		<select name="Module" id="Module" onChange="BlocksModuleHelper(this.value); document.getElementById('Params').value='';">
			<option value="">{lang select_default_name}</option>
			{html_options values=$module_ids selected=$items_arr[0].Module output=$module_names}
		</select>
	</div>
	<div style="float: left;  padding: 5px 0px;" id="moduleForm">
	</div>
</div>