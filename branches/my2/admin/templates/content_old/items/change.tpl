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
          {html_options values=$lang_ids selected=$items_item[0].LangID output=$lang_names}
        </select>
      </td>
    </tr>
    <tr>
      <td>{lang cnt_category}<span class="required">*</span></td>
      <td>
      	<div id="CategoryIDDiv">
	        <select name="CategoryID" id="CategoryID" >
	          <option value="0">{lang select_default_name}</option>
	          {html_options values=$category_ids selected=$items_item[0].CategoryID output=$category_names}
	        </select>
	    </div>
      </td>
    </tr>
    <tr>
      <td>{lang cnt_items_title}<span class="required">*</span></td>
      <td><input type="text" id="Title" name="Title" value="{$items_item[0].Title}" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang cnt_items_short_text}</td>
      <td><textarea id="Short_Text" name="Short_Text" class="form_area">{$items_item[0].Short_Text}</textarea></td>
    </tr>
    <tr>
      <td>{lang cnt_items_full_text}</td>
      <td><textarea id="Full_Text" name="Full_Text" class="form_area">{$items_item[0].Full_Text}</textarea></td>
    </tr>
    <tr>
      <td>{lang cnt_items_published}</td>
      <td>
        {if $items_item[0].Published eq "1"}{assign var="pub_ch" value="checked"}{else}{assign var="pub_ch" value=""}{/if}
        <input type="checkbox" id="Published" name="Published" value="1" {$pub_ch}>
    </td>
    </tr>
    <tr>
      <td>{lang cnt_items_metatitle}</td>
      <td><input type="text" id="MetaTitle" name="MetaTitle" value="{$items_item[0].MetaTitle}" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang cnt_items_metakeywords}</td>
      <td><input type="text" id="MetaKeywords" name="MetaKeywords" value="{$items_item[0].MetaKeywords}" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang cnt_items_metadescription}</td>
      <td><input type="text" id="MetaDescription" name="MetaDescription" value="{$items_item[0].MetaDescription}" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang cnt_items_metaalt}</td>
      <td><input type="text" id="MetaAlt" name="MetaAlt" value="{$items_item[0].MetaAlt}" class="form_item"></td>
    </tr>
    </table>
  </td>
</tr>
<tr valign="bottom">
  <td align="right">
    <input type="hidden" name="id" value="{$items_item[0].ID}">
    <input type="hidden" id="tab_name" name="tab_name" value="{$tab_name}">
    <input type="submit" name="change_item" value="{lang button_change}" class="form_but" onclick="EditorSubmit.UpdateEditorFormValue();items_change(xajax.getFormValues('EXForm')); return false;"></td>
  </td>
</tr>
</table>
</form>