<form id="EXForm" onsubmit="return false;" >
<table border="0" cellpadding="5" cellspacing="0" class="content" width="100%" height="100%" bgcolor="white">
<tr valign="top">
  <td>
    <table border="0" cellpadding="5" cellspacing="0" class="content">
    <tr>
      <td>{lang cnt_category_lang}<span class="required">*</span></td>
      <td>
        <select name="LangID" id="LangID" onChange="showCategories(this.value);">
          <option value="0">{lang select_default_name}</option>
          {html_options values=$lang_ids selected=$lang_id output=$lang_names}
        </select>
      </td>
    </tr>
    <tr>
      <td>{lang cnt_category_name}<span class="required">*</span></td>
      <td><input type="text" id="Name" name="Name" value="" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang cnt_category_parent}</td>
      <td>
      	<div id="ParentIDDiv">
	        <select name="ParentID" id="ParentID">
	          <option value="0">{lang select_default_name}</option>
	          {html_options values=$cat_ids selected=$ParentID output=$cat_names}
	        </select>
	    </div>
      </td>
    </tr>
    <tr>
      <td>{lang cnt_category_description}</td>
      <td><textarea id="Description" name="Description" class="form_area"></textarea></td>
    </tr>
    <tr>
      <td>{lang cnt_category_publish}</td>
      <td>
        <input type="checkbox" id="Published" name="Published" value="1" checked>
      </td>
    </tr>
    </table>
  </td>
</tr>
<tr valign="bottom">
  <td align="right">
    <input type="hidden" id="tab_name" name="tab_name" value="{$tab_name}">
    <input type="submit" name="add_shop" value="{lang button_add}" class="form_but" onclick="categories_add(xajax.getFormValues('EXForm')); return false;"></td>
  </td>
</tr>
</table>
</form>