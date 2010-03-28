<form id="EXForm" onsubmit="return false;" class="niceform">
<input type="hidden"	id="RequiredFields" name="RequiredFields" value="{$required}">

<fieldset>
    <legend>{$component|cat:"_General"|lang}</legend>
    <dl>
        <dt><label for="Name">{$component|cat:"_Name"|lang}</label></dt>
        <dd><input type="text" id="Name" name="Name" value="{$items_arr[0].Name}" class="form_item"></dd>
    </dl>
    <dl>
        <dt><label for="ParentID">{$component|cat:"_ParentID"|lang}</label></dt>
        <dd>
            <select name="ParentID" id="ParentID">
				<option value="0">{lang select_default_name}</option>
				{html_options values=$parent_ids selected=$items_arr[0].ParentID output=$parent_names}
			</select>
        </dd>
    </dl>
    <dl>
        <dt><label for="Description">{$component|cat:"_Description"|lang}</label></dt>
        <dd><textarea id="Description" name="Description">{$items_arr[0].Description}</textarea></dd>
    </dl>
    <dl>
        <dt><label for="Published">{$component|cat:"_Published"|lang}</label></dt>
        <dd>
            {if $items_arr[0].Published eq "1"}{assign var="pub_ch" value="checked"}{else}{assign var="pub_ch" value=""}{/if}
			<input type="checkbox" id="Published" name="Published" value="1" {$pub_ch}>
        </dd>
    </dl>
    <dl>
        <dt><label for="AllowComments">{$component|cat:"_AllowComments"|lang}</label></dt>
        <dd>
            {if $items_arr[0].AllowComments eq "1"}{assign var="AllowComments_ch" value="checked"}{else}{assign var="AllowComments_ch" value=""}{/if}
            <input type="checkbox" id="AllowComments" name="AllowComments" value="1" {$AllowComments_ch}>
        </dd>
    </dl>
</fieldset>
<fieldset class="action">
    <input type="hidden" id="ID" name="ID" value="{$items_arr[0].ID}">
	<input type="hidden" id="tab_name" name="tab_name" value="{$tab_name}">
    {if $form=='change'}
		<input type="submit" name="{$component}_apply" value="{'button_apply'|lang}" class="form_but" onclick="send_form('EXForm', '{$module}', '{$component}', '{$component}_{$form}', true); return false;">
	{/if}
	<input type="submit" name="{$component}_vendors" value="{'button_'|cat:$form|lang}" class="form_but" onclick="send_form('EXForm', '{$module}', '{$component}', '{$component}_{$form}'); return false;">
</fieldset>
</form>
