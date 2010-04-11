<div>
<form id="EXForm" onsubmit="return false;" class="niceform">
<input type="hidden"	id="RequiredFields" name="RequiredFields" value="{$required}">

<div class="left">
    <fieldset>
        <legend>{$component|cat:"_Content"|lang}</legend>
        <dl>
            <dt><label for="Name">{$component|cat:"_Name"|lang}</label></dt>
            <dd><input type="text" id="Name" name="Name" value="{$items_arr[0].Name}" class="form_item"></dd>
        </dl>
        <dl>
            <dt class="line"><label for="Description">{$component|cat:"_Description"|lang}</label></dt>
            <dd>
                <div>
                    <textarea id="Description" name="Description">{$items_arr[0].Description}</textarea>
                </div>
            </dd>
        </dl>
    </fieldset>
</div>
<div class="right">
    <fieldset>
        <legend>{$component|cat:"_General"|lang}</legend>
        <dl>
            <dt><label for="Published">{$component|cat:"_Published"|lang}</label></dt>
            <dd>
                {if $items_arr[0].Published eq "1"}{assign var="pub_ch" value="checked"}{else}{assign var="pub_ch" value=""}{/if}
                <input type="checkbox" id="Published" name="Published" value="1" {$pub_ch}>
            </dd>
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
            <dt><label for="LoginRequired">{$component|cat:"_LoginRequired"|lang}</label></dt>
            <dd>
                {if $items_arr[0].LoginRequired eq "1"}{assign var="LoginRequired_ch" value="checked"}{else}{assign var="LoginRequired_ch" value=""}{/if}
                <input type="checkbox" id="LoginRequired" name="LoginRequired" value="1" {$LoginRequired_ch}>
            </dd>
        </dl>
    </fieldset>
</div>
<div class="action">
    <fieldset class="action">
        <input type="hidden" id="ID" name="ID" value="{$items_arr[0].ID}">
        <input type="hidden" id="tab_name" name="tab_name" value="{$tab_name}">
        {if $form=='change'}
            <input type="submit" name="{$component}_apply" value="{'button_apply'|lang}" onclick="send_form('EXForm', '{$module}', '{$component}', '{$form}', true); return false;">
        {/if}
        <input type="submit" name="{$component}_vendors" value="{'button_'|cat:$form|lang}" onclick="send_form('EXForm', '{$module}', '{$component}', '{$form}'); return false;">
    </fieldset>
</div>
</form>
</div>