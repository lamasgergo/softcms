<script language="JavaScript">
  function set_action_{$mod}(act){ldelim}
    if (act=="add"){ldelim}
      show_form_modules('add');
    {rdelim}
    if (act=="change"){ldelim}
      var boxcount = 0;
      for (i=0; i< document.forms["modules"].length; i++){ldelim}
        var act_reg = new RegExp("^actionid\_.*","i");
        if (act_reg.test(document.forms["modules"].elements[i].name) && document.forms["modules"].elements[i].checked){ldelim}
          var id = document.forms["modules"].elements[i].value;
          boxcount++;
        {rdelim}
      {rdelim}
      if (boxcount==1){ldelim}
        show_form_modules('change',id);
      {rdelim}
      if(boxcount>1){ldelim}
        alert("{lang checkbox_greater_then_1}"); 
      {rdelim}
      if(boxcount==0){ldelim}
        alert("{lang check_items_for_editing}"); 
      {rdelim}
    {rdelim}
    if (act=="publish"){ldelim}
      document.getElementById("form_action").value="publish";
      document.forms["modules"].submit();
    {rdelim}
    if (act=="delete"){ldelim}
      var boxcount = 0;
      var del = false;
      for (i=0; i< document.forms["modules"].length; i++){ldelim}
        var act_reg = new RegExp("^actionid\_.*","i");
        if (act_reg.test(document.forms["modules"].elements[i].name) && document.forms["modules"].elements[i].checked){ldelim}
          var id = document.forms["modules"].elements[i].value;
          boxcount++;
        {rdelim}
      {rdelim}
      if (boxcount==1){ldelim}
        del = true;
      {rdelim}
      if(boxcount>1){ldelim}
        alert("{lang checkbox_greater_then_1}"); 
      {rdelim}
      if(boxcount==0){ldelim}
        alert("{lang check_items_for_deleting}"); 
      {rdelim}
      if (del==true){ldelim}
      if(confirm("{lang modules_delete_confirmation}")){ldelim}
       modules_delete(id);
      {rdelim}
      {rdelim}
    {rdelim}
  {rdelim}
</script>
<table border="0" cellpadding="4" cellspacing="0">
<tr>
    <td>
      <img src="{$images}/menu/add.gif" border="0" title="{lang modules_add}" style="cursor:hand;" onclick="set_action_{$mod}('add');">
      <input type="hidden" name="action_add" value="{$action_add}" id="action_add">
    </td>
    <td>
      <img src="{$images}/menu/change.gif" border="0" title="{lang modules_change}"onclick="set_action_{$mod}('change');" style="cursor:hand;">
      <input type="hidden" name="action_change" value="{$action_change}" id="action_change">
    </td>
    <td>
      <img src="{$images}/menu/del.gif" border="0" title="{lang modules_delete}"onclick="set_action_{$mod}('delete');" style="cursor:hand;">
    </td>
</tr>
</table>