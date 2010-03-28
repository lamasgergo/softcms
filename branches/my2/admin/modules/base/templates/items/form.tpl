<form id="EXForm" onsubmit="return false;" class="niceform">
<input type="hidden"	id="RequiredFields" name="RequiredFields" value="Title, CategoryID">

<fieldset>
    <legend>{$component|cat:"_General"|lang}</legend>

    <dl>
        <dt><label for="Title">{$component|cat:"_Title"|lang}</label></dt>
        <dd>
               <input type="text" id="Title" name="Title" value="{$items_arr[0].Title}">
        </dd>
    </dl>

    <dl>
        <dt><label for="CategoryID">{$component|cat:"_CategoryID"|lang}</label></dt>
        <dd>
            <select name="CategoryID" id="CategoryID" >
                <option value="0">{lang select_default_name}</option>
                {html_options values=$category_ids selected=$items_arr[0].CategoryID output=$category_names}
            </select>
        </dd>
    </dl>

    <dl>
        <dt><label for="Published">{$component|cat:"_Published"|lang}</label></dt>
        <dd>
            {if $items_arr[0].Published eq "1"}{assign var="pub_ch" value="checked"}{else}{assign var="pub_ch" value=""}{/if}
            <input type="checkbox" id="Published" name="Published" value="1" {$pub_ch}>
        </dd>
    </dl>

    <dl>
        <dt><label for="LoginRequired">{$component|cat:"_LoginRequired"|lang}</label></dt>
        <dd>
            {if $items_arr[0].LoginRequired eq "1"}{assign var="LoginRequired_ch" value="checked"}{else}{assign var="LoginRequired_ch" value=""}{/if}
            <input type="checkbox" id="LoginRequired" name="LoginRequired" value="1" {$LoginRequired_ch}>
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

<fieldset>
    <legend>{$component|cat:"_Content"|lang}</legend>

    <dl>
        <dt><label for="Content">{$component|cat:"_Content"|lang}</label></dt>
        <dd>
            <textarea id="Content" name="Content">{$items_arr[0].Content}</textarea>
        </dd>
    </dl>

    <dl>
        <dt><label for="Teaser">{$component|cat:"Teaser"|lang}</label></dt>
        <dd>
            <textarea id="Teaser" name="Teaser">{$items_arr[0].Teaser}</textarea>
        </dd>
    </dl>
</fieldset>

<fieldset>
    <legend>{$component|cat:"_Meta"|lang}</legend>

    <dl>
        <dt><label for="MetaTitle">{$component|cat:"_MetaTitle"|lang}</label></dt>
        <dd>
            <input type="text" id="MetaTitle" name="MetaTitle" value="{$items_arr[0].MetaTitle}" />
        </dd>
    </dl>

    <dl>
        <dt><label for="MetaKeywords">{$component|cat:"_MetaKeywords"|lang}</label></dt>
        <dd>
            <textarea id="MetaKeywords" name="MetaKeywords">{$items_arr[0].MetaKeywords}</textarea>
        </dd>
    </dl>


    <dl>
        <dt><label for="MetaDescription">{$component|cat:"_MetaDescription"|lang}</label></dt>
        <dd>
            <input type="text" id="MetaDescription" name="MetaDescription" value="{$items_arr[0].MetaDescription}" />
        </dd>
    </dl>


    <dl>
        <dt><label for="MetaAlt">{$component|cat:"_MetaAlt"|lang}</label></dt>
        <dd>
            <input type="text" id="MetaAlt" name="MetaAlt" value="{$items_arr[0].MetaAlt}" />
        </dd>
    </dl>

</fieldset>
<fieldset class="action">
    <input type="hidden" id="ID" name="ID" value="{$items_arr[0].ID}">
    <input type="hidden" id="tab_name" name="tab_name" value="{$tab_name}">
    <input type="hidden" id="tab_id" name="tab_id" value="{$tab_id}">
    {if $form=='change'}
        <input type="submit" name="{$component}_apply" value="{'button_apply'|lang}" class="form_but" onclick="send_form('EXForm', '{$module}', '{$component}', '{$component}_{$form}', true); return false;">
    {/if}
    <input type="submit" name="{$component}_vendors" value="{'button_'|cat:$form|lang}" class="form_but" onclick="send_form('EXForm', '{$module}', '{$component}', '{$component}_{$form}'); return false;">    	    
</fieldset>
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