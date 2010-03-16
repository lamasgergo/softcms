<form id="EXForm" onsubmit="return false;" >
<table border="0" cellpadding="5" cellspacing="0" class="content" width="100%" height="100%" bgcolor="white">
<tr valign="top">
  <td>
    <table border="0" cellpadding="5" cellspacing="0" class="content">
    <tr>
      <td>{lang sh_category}<span class="required">*</span></td>
      <td>
        <select name="CategoryID" id="CategoryID" onchange="xajax_xshow_item_properties(xajax.getFormValues('EXForm');">
          <option value="0">{lang select_default_name}</option>
          {html_options values=$category_ids selected=$items_item[0].CategoryID output=$category_names}
        </select>
      </td>
    </tr>
    <tr>
      <td>{lang sh_items_lang}<span class="required">*</span></td>
      <td>
        <select name="LangID" id="LangID">
          <option value="0">{lang select_default_name}</option>
          {html_options values=$lang_ids selected=$items_item[0].LangID output=$lang_names}
        </select>
      </td>
    </tr>
    <tr>
      <td>{lang sh_items_name}<span class="required">*</span></td>
      <td><input type="text" id="Name" name="Name" value="{$items_item[0].Name}" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang sh_items_sku}</td>
      <td><input type="text" id="SKU" name="SKU" value="{$items_item[0].SKU}" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang sh_items_vendor}</td>
      <td>
        <select name="VendorID" id="VendorID">
          <option value="0">{lang select_default_name}</option>
          {html_options values=$vendor_ids selected=$items_item[0].VendorID output=$vendor_names}
        </select>
      </td>
    </tr>
    <tr>
      <td>{lang sh_items_currency}</td>
      <td>
        <select name="CurrencyID" id="CurrencyID">
          <option value="0">{lang currency_default_name}</option>
          {html_options values=$currency_ids selected=$items_item[0].CurrencyID output=$currency_names}
        </select>
      </td>
    </tr>
    <tr>
      <td>{lang sh_items_price}</td>
      <td><input type="text" id="Price" name="Price" value="{$items_item[0].Price}" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang sh_items_in_stock}</td>
      <td><input type="text" id="InStock" name="InStock" value="{$items_item[0].InStock}" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang sh_items_description}</td>
      <td><textarea id="Description" name="Description" class="form_area">{$items_item[0].Description}</textarea></td>
    </tr>
    <tr>
      <td>{lang sh_items_image}</td>
      <td>
       <div id="fileupload">
        <div id="uploaded_files" style="padding:3px;">{$uploaded_files}</div>
        <div id="fileupload_files" style="clear:left;"></div>
        <input readonly type="text" id="image1" name="image1" value="" class="form_item">
            <input type="button" name="image1" value="{lang button_choose}" class="form_but" onclick="window.open('{mod_admin_link value=fileupload}');">
       </div>
      </td>
    </tr>
    <tr>
      <td>{lang sh_items_published}</td>
      <td>
        {if $items_item[0].Published eq "1"}{assign var="pub_ch" value="checked"}{else}{assign var="pub_ch" value=""}{/if}
        <input type="checkbox" id="Published" name="Published" value="1" {$pub_ch}>
      </td>
    </tr>
    <tr>
      <td>{lang sh_category_special}</td>
      <td>
        <select name="SpecialID" id="SpecialID">
          <option value="0">{lang select_default_name}</option>
          {html_options values=$special_ids selected=$items_item[0].SpecialID output=$special_names}
        </select>
      </td>
    </tr>
    <tr>
      <td colspan="2"><div id='properties'>{$properties}</div></td>
    </tr>
    </table>
  </td>
</tr>
<tr valign="bottom">
  <td align="right">
    <input type="hidden" name="id" value="{$items_item[0].ID}">
    <input type="hidden" id="tab_name" name="tab_name" value="{$tab_name}">
    <input type="submit" name="change_item" value="{lang button_change}" class="form_but" onclick="xajax_items_change(xajax.getFormValues('EXForm')); return false;"></td>
  </td>
</tr>
</table>
</form>