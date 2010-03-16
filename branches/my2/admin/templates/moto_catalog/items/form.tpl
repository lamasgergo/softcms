<form id="EXForm" onsubmit="return false;"><input type="hidden"	id="RequiredFields" name="RequiredFields" value="Name, CategoryID">
<table border="0" cellpadding="5" cellspacing="0" class="content"
	width="100%" height="100%" bgcolor="white">
	<tr valign="top">
		<td>
		<table border="0" cellpadding="5" cellspacing="0" class="content">
	    <tr>
	      <td>{$prefix|cat:"_CategoryID"|lang}<span class="required">*</span></td>
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
	      <td>{$prefix|cat:"_Name"|lang}<span class="required">*</span></td>
	      <td><input type="text" id="Name" name="Name" value="{$items_arr[0].Name}" class="form_item"></td>
	    </tr>
	    <tr>
	      <td>{$prefix|cat:"_Description"|lang}</td>
	      <td><textarea id="Description" name="Description" class="form_area">{$items_arr[0].Description}</textarea></td>
	    </tr>
	    <tr>
	      <td>{$prefix|cat:"_ImageGroupID"|lang}</td>
	      <td>
	      	<div id="fileupload">
            <div id="uploaded_files" style="padding:3px;">{$uploaded_files}</div>
            <div id="fileupload_files" style="clear:left;"></div>
            <input readonly type="text" id="image1" name="image1" value="" class="form_item">
            <input readonly type="hidden" id="ImageGroupID" name="ImageGroupID" value="{$items_arr[0].ImageGroupID}">
            <input type="button" name="image1" value="{lang button_choose}" class="form_but" onclick="window.open('{mod_admin_link value=fileupload}');">
	      </td>
	    </tr>
	    <tr>
	      <td>{$prefix|cat:"_Price"|lang}</td>
	      <td><input type="text" id="Price" name="Price" value="{$items_arr[0].Price}" class="form_item"></td>
	    </tr>
	    <tr>
	      <td>{$prefix|cat:"_Year"|lang}</td>
	      <td><input type="text" id="Price" name="Year" value="{$items_arr[0].Year}" class="form_item"></td>
	    </tr>
	    <tr>
	      <td>{$prefix|cat:"_Engine"|lang}</td>
	      <td><input type="text" id="Engine" name="Engine" value="{$items_arr[0].Engine}" class="form_item"></td>
	    </tr>
	    <tr>
	      <td>{$prefix|cat:"_Class"|lang}</td>
	      <td>
				<select name="Class" id="Class" >
		          <option value="0">{lang select_default_name}</option>
		          {html_options values=$class_ids selected=$items_arr[0].Class output=$class_names}
		        </select>
	      </td>
	    </tr>
	    <tr>
	      <td>{$prefix|cat:"_Color"|lang}</td>
	      <td><input type="text" id="Color" name="Color" value="{$items_arr[0].Color}" class="form_item"></td>
	    </tr>
	    <tr>
	      <td>{$prefix|cat:"_Race"|lang}</td>
	      <td><input type="text" id="Race" name="Race" value="{$items_arr[0].Race}" class="form_item"></td>
	    </tr>
	    <tr>
	      <td>{$prefix|cat:"_Status"|lang}</td>
	      <td>
				<select name="Status" id="Status" >
		          <option value="0">{lang select_default_name}</option>
		          {html_options values=$status_ids selected=$items_arr[0].Status output=$status_names}
		        </select>
	      </td>
	    </tr>
	    <tr>
	      <td>{$prefix|cat:"_Published"|lang}</td>
	      <td>
	        {if $items_arr[0].Published eq "1"}{assign var="pub_ch" value="checked"}{else}{assign var="pub_ch" value=""}{/if}
	        <input type="checkbox" id="Published" name="Published" value="1" {$pub_ch}>
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
			<input type="submit" name="{$prefix}_vendors" value="{'button_'|cat:$form|lang}" class="form_but" onclick="{$tab_prefix}_{$form}(xajax.getFormValues('EXForm')); return false;">
		</td>
	</tr>
</table>
</form>
