<form id="EXForm" onsubmit="return false;">
<input type="hidden" id="RequiredFields" name="RequiredFields" value="GroupID,Name,Link">
<table border="0" cellpadding="5" cellspacing="0" class="content" width="100%" height="100%" bgcolor="white">
  <tr valign="top">
    <td>
    <table border="0" cellpadding="5" cellspacing="0" class="content">
      <tr>
        <td>{$prefix|cat:"_group"|lang}<span class="required">*</span></td>
        <td>
        	<select name="GroupID" id="GroupID" onchange="{$tab_prefix}_show_menu_ordernum(this.value);">
        	<option value="0">{lang select_default_name}</option>
        	{html_options values=$group_ids selected=$items_arr[0].GroupID output=$group_names}
        	</select>
        </td>
      </tr>
      <tr>
        <td>{$prefix|cat:"_name"|lang}<span class="required">*</span></td>
        <td><input type="text" id="Name" name="Name" value="{$items_arr[0].Name}" class="form_item"></td>
      </tr>
      <tr>
        <td>{$prefix|cat:"_link"|lang}<span class="required">*</span></td>
        <td><input type="text" id="Link" name="Link" value="{$items_arr[0].Link}" class="form_item"></td>
      </tr>
      <tr>
        <td>{$prefix|cat:"_ordernum"|lang}</td>
        <td>
        	<table class="content">
        	<tr>
        		<td>{$prefix|cat:"_order_before"|lang}</td>
        		<td><input type="radio" name="order" id="order" value="before"></td>
        		<td rowspan="2">
        			<div id="ordernum_div">
        			<select name="OrderNum" id="OrderNum">
        				<option value="0">{lang select_default_name}</option>
        				{html_options values=$OrderNum_ids selected=$items_arr[0].OrderNum output=$OrderNum_names}
        			</select>
        			</div>
        		</td>        		
        	</tr>
        	<tr valign="middle">
        		<td>{$prefix|cat:"_order_after"|lang}</td>
        		<td><input type="radio" name="order" id="order" value="after" {$after_checked}></td>
        	</tr>
        	</table>
        </td>
      </tr>
      <tr>
        <td>{$prefix|cat:"_external"|lang}</td>
        <td>{html_checkboxes name="External" values=$External_ids selected=$items_arr[0].External output=$External_names separator="<br />"}</td>
      </tr>
      
    </table>
    </td>
  </tr>
  <tr valign="bottom">
    <td align="right">
      <input type="hidden" id="ID" name="ID" value="{$items_arr[0].ID}">
      <input type="hidden" id="tab_name" name="tab_name" value="{$tab_name}">
      <input type="submit" name="{$prefix}_vendors" value="{'button_'|cat:$form|lang}" class="form_but" onclick="{$tab_prefix}_{$form}(xajax.getFormValues('EXForm')); return false;">
    </td>
  </tr>
</table>
</form>
