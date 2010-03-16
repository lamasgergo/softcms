<table border="0" cellpadding="0" cellspacing="0">
<tr>
  <td>
    <form id="EXForm" onsubmit="return false;">
    <fieldset>
    <legend>{lang per_rights_add_form_title}</legend>
    <table border="0" cellpadding="5" cellspacing="0" class="content">
    <tr>
    	<td colspan="5">{$info}</td>
    </tr>
    <tr>
      <td>{lang per_rights_show}</td>
      <td>{lang per_rights_add}</td>
      <td>{lang per_rights_change}</td>
      <td>{lang per_rights_delete}</td>
      <td>{lang per_rights_publish}</td>
    </tr>
    <tr>
      <td>
      	{if $IsShow eq "1"}{assign var="isshow" value="checked"}{else}{assign var="isshow" value=""}{/if}
	  	<input type="checkbox" id="isshow" name="isshow" value="1" {$isshow}>
      </td>
      <td>
      	{if $IsAdd eq "1"}{assign var="isadd" value="checked"}{else}{assign var="isadd" value=""}{/if}
      	<input type="checkbox" id="isadd" name="isadd" value="1" {$isadd}>
      </td>
      <td>
      	{if $IsChange eq "1"}{assign var="ischange" value="checked"}{else}{assign var="ischange" value=""}{/if}
      	<input type="checkbox" id="ischange" name="ischange" value="1" {$ischange}>
      </td>
      <td>
      	{if $IsDelete eq "1"}{assign var="isdelete" value="checked"}{else}{assign var="isdelete" value=""}{/if}
      	<input type="checkbox" id="isdelete" name="isdelete" value="1" {$isdelete}>
      </td>
      <td>
      	{if $IsPublish eq "1"}{assign var="ispublish" value="checked"}{else}{assign var="ispublish" value=""}{/if}
      	<input type="checkbox" id="ispublish" name="ispublish" value="1" {$ispublish}>
      </td>
    </tr>
    <tr>
      <td colspan="5" align="right">
      <input type="hidden" name="moduleid" id="moduleid" value="{$moduleid}">
      <input type="hidden" name="groupid" id="groupid" value="{$groupid}">
      <input type="hidden" name="userid" id="userid" value="{$userid}">
      <input type="submit" name="change_rights" value="{lang button_change}" class="form_but" onclick="rights_change(xajax.getFormValues('EXForm')); return false;"></td>
    </tr>
    </table>
    </fieldset>
    </form>
  </td>
</tr>
</table>