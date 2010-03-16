<div style="float: left; padding: 5px 0px;">
	{"banners_name"|lang}:&nbsp;
</div>
<div style="float: left; padding: 5px 0px;">
	<select name="cid" id="cid" onChange="ModuleHelperAddParam(document.getElementById('Params').value, this.name, this.value);">
		<option value="">{lang select_default_name}</option>
		{html_options values=$ids selected=$selected output=$names}
	</select>
</div>
<div style="float: left; padding: 5px 0px;">
	{"banners_options"|lang}: <br /><br />
	{"banners_random"|lang}: 
	<input type="radio" name="random" id="random" value="" onChange="ModuleHelperAddParam(document.getElementById('Params').value, this.name, this.value);" />{"poll_random_no"|lang}
	<input type="radio" name="random" id="random" value="1" onChange="ModuleHelperAddParam(document.getElementById('Params').value, this.name, this.value);"/>{"poll_random_yes"|lang}
	<br>
	{"banners_limit"|lang}:<br>
	<input name="limit" id="limit" onKeyUp="ModuleHelperAddParam(document.getElementById('Params').value, this.name, this.value);">

</div>