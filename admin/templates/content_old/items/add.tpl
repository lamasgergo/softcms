<form id="EXForm" onsubmit="return false;" >
<table border="0" cellpadding="5" cellspacing="0" class="content" width="100%" height="100%" bgcolor="white">
<tr valign="top">
  <td>
    <table border="0" cellpadding="5" cellspacing="0" class="content">
    <tr>
      <td>{lang cnt_items_lang}<span class="required">*</span></td>
      <td>
        <select name="LangID" id="LangID" onChange="show_categories(this.value);">
          <option value="0">{lang select_default_name}</option>
          {html_options values=$lang_ids selected=$lang_id output=$lang_names}
        </select>
      </td>
    </tr>
    <tr>
      <td>{lang cnt_category}<span class="required">*</span></td>
      <td>
      	<div id="CategoryIDDiv">
	        <select name="CategoryID" id="CategoryID">
	          <option value="0">{lang select_default_name}</option>
	        </select>
	    </div>
      </td>
    </tr>
    <tr>
      <td>{lang cnt_items_title}<span class="required">*</span></td>
      <td><input type="text" id="Title" name="Title" value="" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang cnt_items_short_text}</td>
      <td><textarea id="Short_Text" name="Short_Text" class="form_area"></textarea></td>
    </tr>
    <tr>
      <td>{lang cnt_items_full_text}</td>
      <td><textarea id="Full_Text" name="Full_Text" class="form_area"></textarea></td>
    </tr>
    <tr>
      <td>{lang cnt_items_published}</td>
      <td>
        <input type="checkbox" id="Published" name="Published" value="1" checked>
      </td>
    </tr>
    <tr>
      <td>{lang cnt_items_metatitle}</td>
      <td><input type="text" id="MetaTitle" name="MetaTitle" value="" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang cnt_items_metakeywords}</td>
      <td><input type="text" id="MetaKeywords" name="MetaKeywords" value="" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang cnt_items_metadescription}</td>
      <td><input type="text" id="MetaDescription" name="MetaDescription" value="" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang cnt_items_metaalt}</td>
      <td><input type="text" id="MetaAlt" name="MetaAlt" value="" class="form_item"></td>
    </tr>
    </table>
  </td>
</tr>
<tr valign="bottom">
  <td align="right">
    <input type="hidden" id="tab_name" name="tab_name" value="{$tab_name}">
    <input type="submit" name="add_item" value="{lang button_add}" class="form_but" onclick="EditorSubmit.UpdateEditorFormValue();items_add(xajax.getFormValues('EXForm')); return false;"></td>
  </td>
</tr>
</table>
</form>