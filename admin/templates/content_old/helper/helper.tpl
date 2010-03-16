<table border="0" cellpadding="0" cellspacing="5" class="content">
<tr>
	<td>{lang helper_content_category}</td>
	<td>
		<select name="CategoryID" id="CategoryID" class="form_item" onChange="content_helper_showItems(this.value);">
          <option value="0">{lang select_default_name}</option>
          {html_options values=$cat_ids output=$cat_names}
        </select>
    </td>
</tr>
<tr>    
	<td>{lang helper_content_item}</td>
	<td>
		<div id="ItemIDDiv">
			<select name="ItemID" id="ItemID" class="form_item">
	          <option value="0">{lang select_default_name}</option>
	          {html_options values=$item_ids output=$item_names}
	        </select>
		</div>
    </td>
</tr>
<tr>    
	<td colspan="2" align="right">
		<input type="button" name="InsertParam" value="{lang button_insert}" class="form_but">
	</td>
</tr>
</table>