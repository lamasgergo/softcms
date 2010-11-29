<div class="form">
<form id="EXForm" onsubmit="return false;">
<input type="hidden"	id="RequiredFields" name="RequiredFields" value="{$required}">
<div class="action">
<fieldset class="action">
    <input type="hidden" id="ID" name="ID" value="{$items_arr[0].ID}">
    <input type="hidden" id="tab_name" name="tab_name" value="{$tab_name}">
    <input type="hidden" id="tab_id" name="tab_id" value="{$tab_id}">
    {if $form=='change'}
        <input type="submit" name="{$component}_apply" value="{'Apply'|lang}" onclick="send_form('EXForm', '{$module}', '{$component}', '{$form}', true); return false;">
    {/if}
    <input type="submit" name="{$component}_vendors" value="{'Save'|lang}" onclick="send_form('EXForm', '{$module}', '{$component}', '{$form}'); return false;">
</fieldset>
</div>
<div class="left">
    <fieldset>
        <legend>{"General"|lang:$component}</legend>
        
        <dl>
            <dt><label for="SEOName">{"SEOName"|lang:$component}</label></dt>
            <dd>
                   <input type="text" id="SEOName" name="SEOName" value="{$items_arr[0].SEOName}">
            </dd>
        </dl>

        <dl>
            <dt><label for="Name">{"Name"|lang:$component}</label></dt>
            <dd>
                   <input type="text" id="Name" name="Name" value="{$items_arr[0].Name}">
            </dd>
        </dl>

        <dl>
            <dt><label for="Module">{"Module"|lang:$component}</label></dt>
            <dd>
                <select name="Module" id="Module" >
                    <option value="0">{"-- Select --"|lang}</option>
                    {html_options values=$modules selected=$items_arr[0].Module output=$modules}
                </select>
            </dd>
        </dl>

        <dl>
            <dt><label for="ModuleAttr">{"ModuleAttr"|lang:$component}</label></dt>
            <dd>
                   <input type="text" id="ModuleAttr" name="ModuleAttr" value="{$items_arr[0].ModuleAttr}">
            </dd>
        </dl>

        <dl>
            <dt><label for="InMenu">{"InMenu"|lang:$component}</label></dt>
            <dd>
                {if $items_arr[0].InMenu eq "1"}{assign var="InMenu_ch" value="checked"}{else}{assign var="InMenu_ch" value=""}{/if}
                <input type="checkbox" id="InMenu" name="InMenu" value="1" {$InMenu_ch}>
            </dd>
        </dl>
    </fieldset>
</div>
<div class="right">
    <fieldset>
        <legend>{"Attributes"|lang:$component}</legend>

        <dl>
            <dt><label for="ID">{"Module"|lang:$component}</label></dt>
            <dd>
                <select name="Module" id="Module" >
                    <option value="0">{"-- Select --"|lang}</option>
                    {html_options values=$modules selected=$items_arr[0].Module output=$modules}
                </select>
            </dd>
        </dl>

    </fieldset>
</div>
</form>
</div>
