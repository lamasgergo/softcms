<form id="EXForm" onsubmit="return false;"><input type="hidden"
	id="RequiredFields" name="RequiredFields" value="Name,Link">
<table border="0" cellpadding="5" cellspacing="0" class="content"
	width="100%" height="100%" bgcolor="white">
	<tr valign="top">
		<td>
		<table border="0" cellpadding="5" cellspacing="0" class="content">
			<tr>
				<td>{$prefix|cat:"_parent"|lang}</td>
				<td>
				<table>
					<tr>
						<td><select name="ParentID" id="ParentID"
							onchange="{$tab_prefix}_show_menu_ordernum(this.value);">
							<option value="0">{lang select_default_name}</option>
							{html_options values=$parent_ids selected=$items_arr[0].ParentID
							output=$parent_names}
						</select></td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td>{$prefix|cat:"_order"|lang}</td>
				<td>
					<table class="content">
					<tr>
						<td>
							<table class="content">
								<tr>
									<td><input type="radio" name="order" id="order" value="before"></td>
									<td>{$prefix|cat:"_order_before"|lang}</td>
								</tr>
								<tr valign="middle">
									<td><input type="radio" name="order" id="order" value="after"{$after_checked}></td>
									<td>{$prefix|cat:"_order_after"|lang}</td>
								</tr>
							</table>
						</td>
						<td>
							<div id="ordernum_div">
								<select name="OrderNum" id="OrderNum">
									{html_options values=$order_ids selected=$items_arr[0].OrderNum output=$order_names}
								</select>
							</div>
						</td>
					</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>{$prefix|cat:"_name"|lang}<span class="required">*</span></td>
				<td><input type="text" id="Name" name="Name"
					value="{$items_arr[0].Name}" class="form_item"></td>
			</tr>
			<tr>
				<td>{$prefix|cat:"_link"|lang}<span class="required">*</span></td>
				<td><input type="text" id="Link" name="Link"
					value="{$items_arr[0].Link}" class="form_item"></td>
			</tr>
			<tr>
				<td>{$prefix|cat:"_linkalias"|lang}<span class="required">*</span></td>
				<td><input type="text" id="LinkAlias" name="LinkAlias"
					value="{$items_arr[0].LinkAlias}" class="form_item"></td>
			</tr>
			<tr>
				<td>{$prefix|cat:"_external"|lang}</td>
				<td>{html_checkboxes name="External" values=$External_ids
				selected=$items_arr[0].External output=$External_names separator="<br />
				"}</td>
			</tr>
			<tr>
				<td>{$prefix|cat:"_published"|lang}</td>
				<td>
					{if $items_arr[0].Published eq "1"}{assign var="pub_Published" value="checked"}{else}{assign var="pub_Published" value=""}{/if}
					<input type="checkbox" id="Published" name="Published" value="1" {$pub_Published}>
				</td>
			</tr>
			<tr>
		      <td>{$prefix|cat:"_Image"|lang}</td>
		      <td>
		      	<div id="fileupload">
	            <div id="uploaded_files" style="padding:3px;">{$uploaded_files}</div>
	            <div id="fileupload_files" style="clear:left;"></div>
	            <input readonly type="text" id="image1" name="image1" value="" class="form_item">
	            <input readonly type="hidden" id="ImageGroupID" name="ImageGroupID" value="{$items_arr[0].ImageGroupID}">
	            <input type="button" name="image1" value="{lang button_choose}" class="form_but" onclick="window.open('{mod_admin_link value=fileupload}');">
		      </td>
		    </tr>
		</table>
		</td>
	</tr>
	<tr valign="bottom">
		<td align="right"><input type="hidden" id="ID" name="ID"
			value="{$items_arr[0].ID}"> <input type="hidden" id="tab_name"
			name="tab_name" value="{$tab_name}"> <input type="submit"
			name="{$prefix}_vendors" value="{'button_'|cat:$form|lang}"
			class="form_but"
			onclick="{$tab_prefix}_{$form}(xajax.getFormValues('EXForm')); return false;">
		</td>
	</tr>
</table>
</form>


{literal}
<script language="Javascript">
	$(document).ready(function(){
		alert('123');
		$('#fileupload_files').find('div img').each(function(){
			$(this).css('border','1px solid red');
			$(this).click(function(){
				alert($(this).attr('src'));
			});
		});
	});
</script>
{/literal}
