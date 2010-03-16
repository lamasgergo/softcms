<div style="float: left; padding: 5px 0px;">
	{"menu_tree_name"|lang}:&nbsp;
</div>
<div style="float: left; padding: 5px 0px;">
	<select name="parentID" id="parentID" onChange="ModuleHelperAddParam(document.getElementById('Params').value, this.name, this.value);">
		<option value="">{lang select_default_name}</option>
		{html_options values=$ids selected=$selected output=$names}
	</select>
</div>
