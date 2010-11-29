<div class="form">
<form id="EXForm" onsubmit="return false;" class="niceform">
<input type="hidden"	id="RequiredFields" name="RequiredFields" value="{$required}">
<div class="action">
    <fieldset class="action">
        <input type="hidden" id="ID" name="ID" value="{$items_arr[0].ID}">
        <input type="hidden" id="tab_name" name="tab_name" value="{$tab_name}">
        {if $form=='change'}
            <input type="submit" name="{$component}_apply" value="{'Apply'|lang}" onclick="send_form('EXForm', '{$module}', '{$component}', '{$form}', true); return false;">
        {/if}
        <input type="submit" name="{$component}_vendors" value="{'Save'|lang}" onclick="send_form('EXForm', '{$module}', '{$component}', '{$form}'); return false;">
    </fieldset>
</div>
<div class="left">
    <fieldset>
        <legend>{"Content"|lang:$component}</legend>
        <dl>
            <dt><label for="Url">{"Url"|lang:$component}</label></dt>
            <dd>
                   <input type="text" id="Url" name="Url" value="{$items_arr[0].Url|default:''}">
            </dd>
        </dl>
        <dl>
            <dt><label for="Name">{"Name"|lang:$component}</label></dt>
            <dd><input type="text" id="Name" name="Name" value="{$items_arr[0].Name|default:''}" class="form_item"></dd>
        </dl>
        <dl class="line">
            <dt><label for="Description">{"Description"|lang:$component}</label></dt>
            <dd>
                <div>
                    <textarea id="Description" name="Description">{$items_arr[0].Description|default:''}</textarea>
                </div>
            </dd>
        </dl>
    </fieldset>
</div>
<div class="right">
    <fieldset>
        <legend>{"General"|lang:$component}</legend>
        <dl>
            <dt><label for="Published">{"Published"|lang:$component}</label></dt>
            <dd>
                {if $items_arr[0].Published|default:'1' eq "1"}{assign var="pub_ch" value="checked"}{else}{assign var="pub_ch" value=""}{/if}
                <input type="checkbox" id="Published" name="Published" value="1" {$pub_ch}>
            </dd>
        </dl>
        <dl>
            <dt><label for="ParentID">{"ParentID"|lang:$component}</label></dt>
            <dd>
                <select name="ParentID" id="ParentID">
                    <option value="0">{"-- Select --"|lang}</option>
                    {html_options values=$parent_ids selected=$items_arr[0].ParentID|default:'' output=$parent_names}
                </select>
            </dd>
        </dl>
        <dl>
            <dt><label for="LoginRequired">{"LoginRequired"|lang:$component}</label></dt>
            <dd>
                {if $items_arr[0].LoginRequired|default:'0' eq "1"}{assign var="LoginRequired_ch" value="checked"}{else}{assign var="LoginRequired_ch" value=""}{/if}
                <input type="checkbox" id="LoginRequired" name="LoginRequired" value="1" {$LoginRequired_ch}>
            </dd>
        </dl>
    </fieldset>
</div>
</form>
</div>

{literal}
        <script type="text/javascript">
            $(document).ready(function(){
                initEditor('Description', 'Lite');
            });
        </script>
        {/literal}