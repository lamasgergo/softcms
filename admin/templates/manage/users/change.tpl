<form id="EXForm" onsubmit="return false;">
<table border="0" cellpadding="5" cellspacing="0" class="content" width="100%" height="100%" bgcolor="white">
<tr valign="top">
  <td>
    <table border="0" cellpadding="5" cellspacing="0" class="content">
    <tr {$login_dis}>
      <td>{lang users_login}<span class="required">*</span></td>
      <td><input type="text" id="login" name="login" value="{$users[0].Login}" class="form_item"></td>
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
          {html_options values=$lang_ids selected=$users[0].LangID output=$lang_names}
        </select>
      </td>
    </tr>
    <tr {$group_dis}>
      <td>{lang users_groups}<span class="required">*</span></td>
      <td>
        <select name=groupsid id="groupsid">
          <option value="">{lang select_default_name}</option>
          {html_options values=$groups_ids selected=$users[0].GroupID output=$groups_names}
        </select>
      </td>
    </tr>
    <tr>
      <td>{lang users_name}<span class="required">*</span></td>
      <td><input type="text" id="name" name="name" value="{$users[0].Name}" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang users_familyname}</td>
      <td><input type="text" id="familyname" name="familyname" value="{$users[0].Familyname}" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang users_email}</td>
      <td><input type="text" id="email" name="email" value="{$users[0].Email}" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang users_phone}</td>
      <td><input type="text" id="phone" name="phone" value="{$users[0].Phone}" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang users_cellphone}</td>
      <td><input type="text" id="cellphone" name="cellphone" value="{$users[0].Cellphone}" class="form_item"></td>
    </tr>    
    <tr>
      <td>{lang users_country}</td>
      <td><input type="text" id="country" name="country" value="{$users[0].Country}" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang users_zip}</td>
      <td><input type="text" id="zip" name="zip" value="{$users[0].ZIP}" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang users_city}</td>
      <td><input type="text" id="city" name="city" value="{$users[0].City}" class="form_item"></td>
    </tr>
    <tr>
      <td>{lang users_address}</td>
      <td><input type="text" id="address" name="address" value="{$users[0].Address}" class="form_item"></td>
    </tr>
    <tr {$published_dis}>
      <td>{lang users_published}</td>
      <td>
        {if $users[0].Published eq "1"}{assign var="pub_ch" value="checked"}{else}{assign var="pub_ch" value=""}{/if}
        <input type="checkbox" id="published" name="published" value="1" {$pub_ch}>
      </td>
    </tr>
    </table>
  </td>
</tr>
<tr valign="bottom">
  <td align="right">
    <input type="hidden" id="tab_name" name="tab_name" value="{$tab_name}">
    <input type="hidden" name="id" value="{$users[0].ID}">
    <input type="submit" name="change" value="{lang button_change}" class="form_but" onclick="change_users(xajax. getFormValues('EXForm')); return false;"></td>
  </td>
</tr>
</table>
</form>