<div class="form div60_40">
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
        <legend>{"Content"|lang:$component}</legend>
        
        <dl>
            <dt><label for="Url">{"Url"|lang:$component}</label></dt>
            <dd>
                   <input type="text" id="Url" name="Url" value="{$items_arr[0].Url}">
            </dd>
        </dl>

        <dl>
            <dt><label for="Title">{"Title"|lang:$component}</label></dt>
            <dd>
                   <input type="text" id="Title" name="Title" value="{$items_arr[0].Title}">
            </dd>
        </dl>

        <dl class="line">
            <dt><label for="Content">{"Content"|lang:$component}</label></dt>
            <dd>
                <div>
                    <textarea id="Content" name="Content" class="wysiwyg">{$items_arr[0].Content}</textarea>
                </div>                    
            </dd>
        </dl>

        <dl class="line">
            <dt><a href="javascript:void(0);" onclick="$('dl:has(#Teaser)').show();">{"Show Teaser"|lang:$component}</a></dt>
        </dl>

        <dl class="line" style="display:none;">
            <dt><label for="Teaser">{$component|cat:"Teaser"|lang:$component}</label></dt>
            <dd>
                <div>
                    <textarea id="Teaser" name="Teaser" class="wysiwygLite">{$items_arr[0].Teaser}</textarea>
                </div>
            </dd>
        </dl>
    </fieldset>
</fieldset>
</div>
<div class="right">
    <fieldset>
        <legend>{"General"|lang:$component}</legend>

        <dl>
            <dt><label for="CategoryID">{"CategoryID"|lang:$component}</label></dt>
            <dd>
                <select name="CategoryID" id="CategoryID" >
                    <option value="0">{"-- Select --"|lang}</option>
                    {html_options values=$category_ids selected=$items_arr[0].CategoryID output=$category_names}
                </select>
            </dd>
        </dl>

        <dl>
            <dt><label for="Published">{"Published"|lang:$component}</label></dt>
            <dd>
                {if $items_arr[0].Published eq "1"}{assign var="pub_ch" value="checked"}{else}{assign var="pub_ch" value=""}{/if}
                <input type="checkbox" id="Published" name="Published" value="1" {$pub_ch}>
            </dd>
        </dl>

        <dl>
            <dt><label for="LoginRequired">{"LoginRequired"|lang:$component}</label></dt>
            <dd>
                {if $items_arr[0].LoginRequired eq "1"}{assign var="LoginRequired_ch" value="checked"}{else}{assign var="LoginRequired_ch" value=""}{/if}
                <input type="checkbox" id="LoginRequired" name="LoginRequired" value="1" {$LoginRequired_ch}>
            </dd>
        </dl>


        <dl>
            <dt><label for="LoginRequired">{"LoginRequired"|lang:$component}</label></dt>
            <dd>
                {if $items_arr[0].LoginRequired eq "1"}{assign var="LoginRequired_ch" value="checked"}{else}{assign var="LoginRequired_ch" value=""}{/if}
                <input type="checkbox" id="LoginRequired" name="LoginRequired" value="1" {$LoginRequired_ch}>
            </dd>
        </dl>
    </fieldset>
    <fieldset>
        <legend>{"Meta"|lang:$component}</legend>

        <dl>
            <dt><label for="MetaTitle">{"MetaTitle"|lang:$component}</label></dt>
            <dd>
                <input type="text" id="MetaTitle" name="MetaTitle" value="{$items_arr[0].MetaTitle}" />
            </dd>
        </dl>

        <dl>
            <dt><label for="MetaKeywords">{"MetaKeywords"|lang:$component}</label></dt>
            <dd>
                <textarea id="MetaKeywords" name="MetaKeywords">{$items_arr[0].MetaKeywords}</textarea>
            </dd>
        </dl>


        <dl>
            <dt><label for="MetaDescription">{"MetaDescription"|lang:$component}</label></dt>
            <dd>
                <input type="text" id="MetaDescription" name="MetaDescription" value="{$items_arr[0].MetaDescription}" />
            </dd>
        </dl>


        <dl>
            <dt><label for="MetaAlt">{"MetaAlt"|lang:$component}</label></dt>
            <dd>
                <input type="text" id="MetaAlt" name="MetaAlt" value="{$items_arr[0].MetaAlt}" />
            </dd>
        </dl>
    </fieldset>
</div>
</form>
</div>
        {literal}
        <script type="text/javascript">
            $(document).ready(function(){
                initEditor('Content');
                initEditor('Teaser', 'Lite');
            });
        </script>
        {/literal}