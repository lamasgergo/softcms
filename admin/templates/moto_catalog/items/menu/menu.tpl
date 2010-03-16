<script language="JavaScript">
  function set_action_{$tab_prefix}(act){ldelim}
    if (act=="add"){ldelim}
      {$tab_prefix}_form('add','{$tab_id}');
    {rdelim}
    if (act=="change"){ldelim}
      var boxcount = 0;
      for (i=0; i< document.forms["{$tab_prefix}"].length; i++){ldelim}
        var act_reg = new RegExp("^actionid\_.*","i");
        if (act_reg.test(document.forms["{$tab_prefix}"].elements[i].name) && document.forms["{$tab_prefix}"].elements[i].checked){ldelim}
          var id = document.forms["{$tab_prefix}"].elements[i].value;
          boxcount++;
        {rdelim}
      {rdelim}
      if (boxcount==1){ldelim}
        {$tab_prefix}_form('change','{$tab_id}',id);
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
      document.forms["{$tab_prefix}"].submit();
    {rdelim}
    if (act=="delete"){ldelim}
      var boxcount = 0;
      var del = false;
      for (i=0; i< document.forms["{$tab_prefix}"].length; i++){ldelim}
        var act_reg = new RegExp("^actionid\_.*","i");
        if (act_reg.test(document.forms["{$tab_prefix}"].elements[i].name) && document.forms["{$tab_prefix}"].elements[i].checked){ldelim}
          var id = document.forms["{$tab_prefix}"].elements[i].value;
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
       {$tab_prefix}_delete(id,'{$tab_id}');
      {rdelim}
      {rdelim}
    {rdelim}
  {rdelim}
</script>
<table border="0" cellpadding="4" cellspacing="0" width="100%">
<tr>
    <td>
      <img src="{$images}/menu/add.gif" border="0" title="{$prefix|cat:'_add'|lang}" style="cursor:hand;" onclick="set_action_{$tab_prefix}('add');">
    </td>
    <td>
      <img src="{$images}/menu/change.gif" border="0" title="{$prefix|cat:'_change'|lang}"onclick="set_action_{$tab_prefix}('change');" style="cursor:hand;">
    </td>
    <td>
      <img src="{$images}/menu/del.gif" border="0" title="{$prefix|cat:'_delete'|lang}"onclick="set_action_{$tab_prefix}('delete');" style="cursor:hand;">
    </td>
</tr>
</table>