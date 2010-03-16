<div style="float: left; padding: 5px 0px;">
	{"content_category_name"|lang}:&nbsp;
</div>
<div style="float: left; padding: 5px 0px;">
	<select name="cid" id="cid" onChange="ModuleHelperAddParam(document.getElementById('Params').value, this.name, this.value);">
		<option value="">{lang select_default_name}</option>
		{html_options values=$cids selected=$cid output=$cnames}
	</select>
</div>
<div style="clear: both;">
<div style="float: left; padding: 5px 0px;">
	{"content_name"|lang}:&nbsp;
</div>
<div style="float: left; padding: 5px 0px;">
	<select name="iid" id="iid" onChange="ModuleHelperAddParam(document.getElementById('Params').value, this.name, this.value);">
		<option value="">{lang select_default_name}</option>
		{html_options values=$ids selected=$selected output=$names}
	</select>
</div>
<div style="float: left; padding: 5px 0px;">
	{"content_options"|lang}: <br /><br />
	{"content_tpl"|lang}: 
	<select name="tpl" id="tpl" onChange="ModuleHelperAddParam(document.getElementById('Params').value, this.name, this.value);">
		<option value="">{lang select_default_name}</option>
		{html_options values=$tpl_ids selected=$tpl_selected output=$tpl_names}		
	</select>
	<br>
	{"content_limit"|lang}:<br>
	<input name="limit" id="limit" onKeyUp="ModuleHelperAddParam(document.getElementById('Params').value, this.name, this.value);">
</div>