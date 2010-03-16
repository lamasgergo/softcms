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