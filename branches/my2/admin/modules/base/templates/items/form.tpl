<form id="EXForm" onsubmit="return false;"><input type="hidden"	id="RequiredFields" name="RequiredFields" value="Title,Created">
<table border="0" cellpadding="5" cellspacing="0" class="content"
	width="100%" height="100%" bgcolor="white">
	<tr valign="top">
		<td>
		<table border="0" cellpadding="5" cellspacing="0" class="content">
		<tr>
	      <td>{lang cnt_menu}</td>
	      <td>
				<select name="MenuID" id="MenuID" >
		          <option value="0">{lang select_default_name}</option>
		          {html_options values=$menu_ids selected=$items_arr[0].MenuID output=$menu_names}
		        </select>
	      </td>
	    </tr>
		<tr>
	      <td>{lang cnt_LoginRequired}</td>
	      <td>
			{if $items_arr[0].LoginRequired eq "1"}{assign var="pub_LoginRequired" value="checked"}{else}{assign var="pub_LoginRequired" value=""}{/if}
	        <input type="checkbox" id="LoginRequired" name="LoginRequired" value="1" {$pub_LoginRequired}>
	      </td>
	    </tr>
	    <tr>
	      <td>{lang cnt_category}<span class="required">*</span></td>
	      <td>
	      	<div id="CategoryIDDiv">
		        <select name="CategoryID" id="CategoryID" >
		          <option value="0">{lang select_default_name}</option>
		          {html_options values=$category_ids selected=$items_arr[0].CategoryID output=$category_names}
		        </select>
		    </div>
	      </td>
	    </tr>
	    <tr>
	      <td>{lang cnt_items_title}<span class="required">*</span></td>
	      <td><input type="text" id="Title" name="Title" value="{$items_arr[0].Title}" class="form_item"></td>
	    </tr>
	    <tr>
	      <td>
	      	{lang cnt_items_short_text}
	      </td>
	      <td><textarea id="Short_Text" name="Short_Text" class="form_area">{$items_arr[0].Short_Text}</textarea></td>
	    </tr>
	    <tr>
	      <td>{lang cnt_items_full_text}</td>
	      <td><textarea id="Full_Text" name="Full_Text" class="form_area">{$items_arr[0].Full_Text}</textarea></td>
	    </tr>
	    <tr>
	      <td>{lang cnt_items_published}</td>
	      <td>
	        {if $items_arr[0].Published eq "1"}{assign var="pub_ch" value="checked"}{else}{assign var="pub_ch" value=""}{/if}
	        <input type="checkbox" id="Published" name="Published" value="1" {$pub_ch}>
	    </td>
	    </tr>
		<tr>
				<td>{$module|cat:"_AllowComments"|lang}</td>
				<td>
					{if $items_arr[0].AllowComments eq "1"}{assign var="AllowComments_ch" value="checked"}{else}{assign var="AllowComments_ch" value=""}{/if}
					<input type="checkbox" id="AllowComments" name="AllowComments" value="1" {$AllowComments_ch}>
				</td>
			</tr>
	    <tr>
	      <td>{lang cnt_items_created}<span class="required">*</span></td>
	      <td>
			<input type="text" id="Created" name="Created" readonly value="{$items_arr[0].Created|date_format:"%Y-%m-%d %H:%M"}" class="form_item">
		  </td>
	    </tr>
	    <tr>
	      <td>{lang cnt_items_metatitle}</td>
	      <td><input type="text" id="MetaTitle" name="MetaTitle" value="{$items_arr[0].MetaTitle}" class="form_item"></td>
	    </tr>
	    <tr>
	      <td>{lang cnt_items_metakeywords}</td>
	      <td><input type="text" id="MetaKeywords" name="MetaKeywords" value="{$items_arr[0].MetaKeywords}" class="form_item"></td>
	    </tr>
	    <tr>
	      <td>{lang cnt_items_metadescription}</td>
	      <td><input type="text" id="MetaDescription" name="MetaDescription" value="{$items_arr[0].MetaDescription}" class="form_item"></td>
	    </tr>
	    <tr>
	      <td>{lang cnt_items_metaalt}</td>
	      <td><input type="text" id="MetaAlt" name="MetaAlt" value="{$items_arr[0].MetaAlt}" class="form_item"></td>
	    </tr>
	    </table>
		</td>
	</tr>
	<tr valign="bottom">
		<td align="right">
			<input type="hidden" id="ID" name="ID" value="{$items_arr[0].ID}">
			<input type="hidden" id="tab_name" name="tab_name" value="{$tab_name}">
			<input type="hidden" id="tab_id" name="tab_id" value="{$tab_id}">
			{if $form=='change'}
				<input type="submit" name="{$module}_apply" value="{'button_apply'|lang}" class="form_but" onclick="send_form('EXForm', '{$module}', '{$component}', '{$component}_{$form}', true); return false;">
			{/if}
			<input type="submit" name="{$module}_vendors" value="{'button_'|cat:$form|lang}" class="form_but" onclick="send_form('EXForm', '{$module}', '{$component}', '{$component}_{$form}'); return false;">
		</td>
	</tr>
</table>
</form>

        {literal}
        <script type="text/javascript">
            $(document).ready(function(){
                $('#Created').datepicker({ dateFormat: 'yy-mm-dd' });
                initEditorFull('Full_Text');
                initEditorLite('Short_Text');
            });
        </script>
        {/literal}