{literal}
<script>
	$(function(){
		$.fck.path = '/admin/source/editors/FCKEditor/';
		$('#Short_Text').fck({toolbar: 'Default', height: 400, width: 700});
		$('#Full_Text').fck({toolbar: 'Default', height: 600, width:700});
	});
	$(document).ready(function(){
		$('#Created').datepicker({dateFormat:'yy-mm-dd', yearRange: '1950:2020'});
		$('.ui-datepicker').css('z-index', 5);
	});
</script>
{/literal}


<form id="EXForm" onsubmit="return false;"><input type="hidden"	id="RequiredFields" name="RequiredFields" value="Title,Created">
<table border="0" cellpadding="5" cellspacing="0" class="content"
	width="100%" height="100%" bgcolor="white">
	<tr valign="top">
		<td>
		<table border="0" cellpadding="5" cellspacing="0" class="content">
		<tr>
	      <td>{$component|cat:"_MenuID"|lang}</td>
	      <td>
				<select name="MenuID" id="MenuID" >
		          <option value="0">{lang select_default_name}</option>
		          {html_options values=$menu_ids selected=$data.MenuID output=$menu_names}
		        </select>
	      </td>
	    </tr>
		<tr>
	      <td>{$component|cat:"_LoginRequired"|lang}</td>
	      <td>
			{if $data.LoginRequired eq "1"}{assign var="pub_LoginRequired" value="checked"}{else}{assign var="pub_LoginRequired" value=""}{/if}
	        <input type="checkbox" id="LoginRequired" name="LoginRequired" value="1" {$pub_LoginRequired}>
	      </td>
	    </tr>
	    <tr>
	      <td>{$component|cat:"_CategoryID"|lang}<span class="required">*</span></td>
	      <td>
	      	<div id="CategoryIDDiv">
		        <select name="CategoryID" id="CategoryID" >
		          <option value="0">{lang select_default_name}</option>
		          {html_options values=$category_ids selected=$data.CategoryID output=$category_names}
		        </select>
		    </div>
	      </td>
	    </tr>
	    <tr>
	      <td>{$component|cat:"_Title"|lang}<span class="required">*</span></td>
	      <td><input type="text" id="Title" name="Title" value="{$data.Title}" class="form_item"></td>
	    </tr>
	    <tr>
	      <td>
	      	{$component|cat:"_Short_Text"|lang}
	      </td>
	      <td><textarea id="Short_Text" name="Short_Text" class="form_area">{$data.Short_Text}</textarea></td>
	    </tr>
	    <tr>
	      <td>{$component|cat:"_Full_Text"|lang}</td>
	      <td><textarea id="Full_Text" name="Full_Text" class="form_area">{$data.Full_Text}</textarea></td>
	    </tr>
	    <tr>
	      <td>{$component|cat:"_Published"|lang}</td>
	      <td>
	        {if $data.Published eq "1"}{assign var="pub_ch" value="checked"}{else}{assign var="pub_ch" value=""}{/if}
	        <input type="checkbox" id="Published" name="Published" value="1" {$pub_ch}>
	    </td>
	    </tr>
		<tr>
				<td>{$component|cat:"_AllowComments"|lang}</td>
				<td>
					{if $data.AllowComments eq "1"}{assign var="AllowComments_ch" value="checked"}{else}{assign var="AllowComments_ch" value=""}{/if}
					<input type="checkbox" id="AllowComments" name="AllowComments" value="1" {$AllowComments_ch}>
				</td>
			</tr>
	    <tr>
	      <td>{$component|cat:"_Created"|lang}</td>
	      <td>
			<input type="text" id="Created" name="Created" value="{$data.Created}" class="form_item">
		  </td>
	    </tr>
	    <tr>
	      <td>{$component|cat:"_MetaTitle"|lang}</td>
	      <td><input type="text" id="MetaTitle" name="MetaTitle" value="{$data.MetaTitle}" class="form_item"></td>
	    </tr>
	    <tr>
	      <td>{$component|cat:"_MetaKeywords"|lang}</td>
	      <td><input type="text" id="MetaKeywords" name="MetaKeywords" value="{$data.MetaKeywords}" class="form_item"></td>
	    </tr>
	    <tr>
	      <td>{$component|cat:"_MetaDescription"|lang}</td>
	      <td><input type="text" id="MetaDescription" name="MetaDescription" value="{$data.MetaDescription}" class="form_item"></td>
	    </tr>
	    <tr>
	      <td>{$component|cat:"_MetaAlt"|lang}</td>
	      <td><input type="text" id="MetaAlt" name="MetaAlt" value="{$data.MetaAlt}" class="form_item"></td>
	    </tr>
	    </table>
		</td>
	</tr>
	<tr valign="bottom">
		<td align="right">
			<input type="hidden" id="ID" name="ID" value="{$data.ID}" class="form_item">
			{if $form=='change'}
				<input type="submit" id="submitApply" name="{$prefix}_apply" value="{'button_apply'|lang}" class="form_but" onclick="EditorSubmit.UpdateEditorFormValue(); xajax_{$component}_change(xajax.getFormValues('EXForm'), true); return false;">
			{/if}
			<input type="submit" id="submitSave" name="{$component}_submit" value="{'button_'|cat:$form|lang}" class="form_but" onclick="EditorSubmit.UpdateEditorFormValue(); xajax_{$component}_{$form}(xajax.getFormValues('EXForm')); return false;">
		</td>
	</tr>
</table>
</form>
