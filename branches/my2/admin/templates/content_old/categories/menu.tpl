<script language="JavaScript">
  function set_action_{$mod}(act){ldelim}
    if (act=="add"){ldelim}
      show_form_categories('add');
    {rdelim}
    if (act=="change"){ldelim}
      var boxcount = 0;
      for (i=0; i< document.forms["categories"].length; i++){ldelim}
        var act_reg = new RegExp("^actionid\_.*","i");
        if (act_reg.test(document.forms["categories"].elements[i].name) && document.forms["categories"].elements[i].checked){ldelim}
          var id = document.forms["categories"].elements[i].value;
          boxcount++;
        {rdelim}
      {rdelim}
      if (boxcount==1){ldelim}
        show_form_categories('change',id);
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
      document.forms["categories"].submit();
    {rdelim}
    if (act=="delete"){ldelim}
      var boxcount = 0;
      var del = false;
      for (i=0; i< document.forms["categories"].length; i++){ldelim}
        var act_reg = new RegExp("^actionid\_.*","i");
        if (act_reg.test(document.forms["categories"].elements[i].name) && document.forms["categories"].elements[i].checked){ldelim}
          var id = document.forms["categories"].elements[i].value;
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
      if(confirm("{lang delete_confirmation}")){ldelim}
       categories_delete(id);
      {rdelim}
      {rdelim}
    {rdelim}
  {rdelim}
</script>
<table border="0" cellpadding="4" cellspacing="0" width="100%">
<tr>
    <td>
      <img src="{$images}/menu/add.gif" border="0" title="{lang categories_add}" style="cursor:hand;" onclick="set_action_{$mod}('add');">
      <input type="hidden" name="action_add" value="{$action_add}" id="action_add">
    </td>
    <td>
      <img src="{$images}/menu/change.gif" border="0" title="{lang categories_change}"onclick="set_action_{$mod}('change');" style="cursor:hand;">
      <input type="hidden" name="action_change" value="{$action_change}" id="action_change">
    </td>
    <td>
      <img src="{$images}/menu/del.gif" border="0" title="{lang categories_delete}"onclick="set_action_{$mod}('delete');" style="cursor:hand;">
    </td>
    <td width="90%" align="right">
      &nbsp;
    </td>
</tr>
</table>