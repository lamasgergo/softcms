<form id="EXForm" onsubmit="return false;" >
<table border="0" cellpadding="5" cellspacing="0" class="content" width="100%" height="100%" bgcolor="white">
<tr valign="top">
  <td>
    <table border="0" cellpadding="5" cellspacing="0" class="content">
    <tr>
      <td>{lang specials_name}<span class="required">*</span></td>
      <td><input type="text" id="Name" name="Name" value="{$special_arr[0].Name}" class="form_item"></td>
    </tr>
    </table>
  </td>
</tr>
<tr valign="bottom">
  <td align="right">
    <input type="hidden" name="id" value="{$special_arr[0].ID}">
    <input type="hidden" id="tab_name" name="tab_name" value="{$tab_name}">
    <input type="submit" name="change_scatalog" value="{lang button_change}" class="form_but" onclick="modules_change(xajax.getFormValues('EXForm')); return false;"></td>
  </td>
</tr>
</table>
</form>