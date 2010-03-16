<form id="EXForm" onsubmit="return false;">
<table border="0" cellpadding="5" cellspacing="0" class="content" width="100%" height="100%" bgcolor="white">
<tr valign="top">
  <td>
    <table border="0" cellpadding="5" cellspacing="0" class="content">
    <tr>
      <td>{lang users_login}<span class="required">*</span></td>
      <td><input type="text" id="login" name="login" value="" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang users_password}<span class="required">*</span></td>
      <td><input type="password" id="password" name="password" value="" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang users_lang}<span class="required">*</span></td>
      <td>
        <select name=langid id="langid">
          <option value="">{lang select_default_name}</option>
          {html_options values=$lang_ids selected=$lang_id output=$lang_names}
        </select>
      </td>
    </tr>
    <tr>
      <td>{lang users_groups}<span class="required">*</span></td>
      <td>
        <select name=groupsid id="groupsid">
          <option value="">{lang select_default_name}</option>
          {html_options values=$groups_ids selected=$groups_id output=$groups_names}
        </select>
      </td>
    </tr>
    <tr>
      <td>{lang users_name}<span class="required">*</span></td>
      <td><input type="text" id="name" name="name" value="" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang users_familyname}</td>
      <td><input type="text" id="familyname" name="familyname" value="" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang users_email}</td>
      <td><input type="text" id="email" name="email" value="" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang users_phone}</td>
      <td><input type="text" id="phone" name="phone" value="" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang users_cellphone}</td>
      <td><input type="text" id="cellphone" name="cellphone" value="" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang users_country}</td>
      <td><input type="text" id="country" name="country" value="" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang users_zip}</td>
      <td><input type="text" id="zip" name="zip" value="" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang users_city}</td>
      <td><input type="text" id="city" name="city" value="" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang users_address}</td>
      <td><input type="text" id="address" name="address" value="" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang users_published}</td>
      <td><input type="checkbox" id="published" name="published" value="1" checked></td>
    </tr>
    </table>

  </td>
</tr>
<tr valign="bottom">
  <td align="right">
    <input type="hidden" id="tab_name" name="tab_name" value="{$tab_name}">
    <input type="submit" name="add" value="{lang button_add}" class="form_but" onclick="add_users(xajax.getFormValues('EXForm')); return false;">
  </td>
</tr>
</table>
</form>