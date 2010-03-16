<script type="text/javascript" src="/source/editors/FCKEditor/fckeditor.js"></script>

<script type="text/javascript">
      function initEditor()
      {ldelim}
        var oFCKeditor = new FCKeditor( 'Full_Text' ) ;
        oFCKeditor.BasePath = "/source/editors/FCKEditor/" ;

        oFCKeditor.Config["CustomConfigurationsPath"] = oFCKeditor.BasePath+"sconfig.js"  ;
        oFCKeditor.Width = 650;
        oFCKeditor.Height = 400;
        oFCKeditor.Config["AutoDetectLanguage"] = true ;
        oFCKeditor.Config["DefaultLanguage"]    = "ru" ;
        oFCKeditor.ReplaceTextarea() ;

        var oFCKeditor2 = new FCKeditor( 'Short_Text' ) ;
        oFCKeditor2.BasePath = "/source/editors/FCKEditor/" ;

        oFCKeditor2.Config["CustomConfigurationsPath"] = oFCKeditor.BasePath+"sconfig.js"  ;
        oFCKeditor2.ToolbarSet = 'Short';
        oFCKeditor2.Width = 650;
        oFCKeditor2.Height = 300;
        oFCKeditor2.Config["AutoDetectLanguage"] = true ;
        oFCKeditor2.Config["DefaultLanguage"]    = "ru" ;
        oFCKeditor2.ReplaceTextarea() ;
      {rdelim}

function EditorSubmit()
{ldelim}
        this.UpdateEditorFormValue = function()
        {ldelim}
                for ( i = 0; i < parent.frames.length; ++i )
                        if ( parent.frames[i].FCK )
                                parent.frames[i].FCK.UpdateLinkedField();
        {rdelim}
{rdelim}
// instantiate the class
var EditorSubmit = new EditorSubmit();
</script>

<script language="JavaScript">
  function set_action_{$mod}(act){ldelim}
    if (act=="add"){ldelim}
      show_form_items('add');
    {rdelim}
    if (act=="change"){ldelim}
      var boxcount = 0;
      for (i=0; i< document.forms["items"].length; i++){ldelim}
        var act_reg = new RegExp("^actionid\_.*","i");
        if (act_reg.test(document.forms["items"].elements[i].name) && document.forms["items"].elements[i].checked){ldelim}
          var id = document.forms["items"].elements[i].value;
          boxcount++;
        {rdelim}
      {rdelim}
      if (boxcount==1){ldelim}
        show_form_items('change',id);
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
      document.forms["items"].submit();
    {rdelim}
    if (act=="delete"){ldelim}
      var boxcount = 0;
      var del = false;
      for (i=0; i< document.forms["items"].length; i++){ldelim}
        var act_reg = new RegExp("^actionid\_.*","i");
        if (act_reg.test(document.forms["items"].elements[i].name) && document.forms["items"].elements[i].checked){ldelim}
          var id = document.forms["items"].elements[i].value;
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
       items_delete(id);
      {rdelim}
      {rdelim}
    {rdelim}
  {rdelim}
</script>
<table border="0" cellpadding="4" cellspacing="0" width="100%">
<tr>
    <td>
      <img src="{$images}/menu/add.gif" border="0" title="{lang items_add}" style="cursor:hand;" onclick="set_action_{$mod}('add');">
      <input type="hidden" name="action_add" value="{$action_add}" id="action_add">
    </td>
    <td>
      <img src="{$images}/menu/change.gif" border="0" title="{lang items_change}"onclick="set_action_{$mod}('change');" style="cursor:hand;">
      <input type="hidden" name="action_change" value="{$action_change}" id="action_change">
    </td>
    <td>
      <img src="{$images}/menu/del.gif" border="0" title="{lang items_delete}"onclick="set_action_{$mod}('delete');" style="cursor:hand;">
    </td>
    <td width="90%" align="right">
      
    </td>
</tr>
</table>