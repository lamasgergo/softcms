<form method="POST">
<table border="0" cellpadding="0" cellspacing="0" class="langTable">
<tr>
	<td colspan="2">{$moduleName}</td>
</tr>
<tr>
	<td class="line"><img src="{$design_images}/grey_line.gif"></td>
	<td class="input">
		<select name="language" id="language" class="select">
			{html_options values=$lang_ids selected=$lang_id output=$lang_names}
		</select>
		<input type="image" src="{$design_images}/ok.gif">
	</td>
</tr>
</table>
</form>