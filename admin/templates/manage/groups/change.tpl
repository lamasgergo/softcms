<form id="EXForm" onsubmit="return false;">
<table border="0" cellpadding="5" cellspacing="0" class="content" width="100%" height="100%" bgcolor="white">
<tr valign="top">
  <td>
    <table border="0" cellpadding="5" cellspacing="0" class="content">
    <tr>
      <td>{lang groups_caption}<span class="required">*</span></td>
      <td><input type="text" id="name" name="name" value="{$name}" class="form_item"></td>
    </tr>
    </table>
  </td>
</tr>
<tr valign="bottom">
  <td align="right">
    <input type="hidden" id="tab_name" name="tab_name" value="{$tab_name}">
    <input type="hidden" id="id" name="id" value="{$id}">
    <input type="submit" name="change_group" value="{lang button_change}" class="form_but" onclick="groups_change(xajax. getFormValues('EXForm')); return false;">
  </td>
</tr>
</table>
</form>