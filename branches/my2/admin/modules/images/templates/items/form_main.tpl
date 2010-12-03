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
            <dt><label for="Title">{"Title"|lang:$component}</label></dt>
            <dd>
                <input type="text" id="Title" name="Title" value="{$items_arr[0].Title|default:''}">
            </dd>
        </dl>

        <dl class="line">
            <dt><label for="Content">{"Content"|lang:$component}</label></dt>
            <dd>
                <div>
                    <textarea id="Content" name="Content" class="wysiwyg">{$items_arr[0].Content|default:''}</textarea>
                </div>
            </dd>
        </dl>

        <dl class="line">
            <dt>
                <a href="javascript:void(0);" onclick="$('dl:has(#Teaser)').show();">{"Show Teaser"|lang:$component|default:''}</a>
            </dt>
        </dl>

        <dl class="line" style="display:none;">
            <dt><label for="Teaser">{$component|cat:"Teaser"|lang:$component}</label></dt>
            <dd>
                <div>
                    <textarea id="Teaser" name="Teaser" class="wysiwygLite">{$items_arr[0].Teaser|default:''}</textarea>
                </div>
            </dd>
        </dl>
    </fieldset>
</div>
<div class="right">
    <fieldset>
        <legend>{"General"|lang:$component}</legend>

        <dl>
            <dt><label for="CategoryID">{"CategoryID"|lang:$component}</label></dt>
            <dd>
                <select name="CategoryID" id="CategoryID">
                    <option value="0">{"-- Select --"|lang}</option>
                    {html_options values=$category_ids selected=$items_arr[0].CategoryID|default:'' output=$category_names}
                </select>
            </dd>
        </dl>

        <dl>
            <dt><label for="Published">{"Published"|lang:$component}</label></dt>
            <dd>
                {if $items_arr[0].Published|default:'1' eq "1"}{assign var="pub_ch" value="checked"}{else}{assign var="pub_ch" value=""}{/if}
                <input type="checkbox" id="Published" name="Published" value="1" {$pub_ch}>
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

    <fieldset>
        <legend>{"Meta"|lang:$component}</legend>

        <dl>
            <dt><label for="MetaTitle">{"MetaTitle"|lang:$component}</label></dt>
            <dd>
                <input type="text" id="MetaTitle" name="MetaTitle" value="{$items_arr[0].MetaTitle|default:''}"/>
            </dd>
        </dl>

        <dl>
            <dt><label for="MetaKeywords">{"MetaKeywords"|lang:$component}</label></dt>
            <dd>
                <input id="MetaKeywords" name="MetaKeywords" value="{$items_arr[0].MetaKeywords|default:''}"/>
            </dd>
        </dl>


        <dl>
            <dt><label for="MetaDescription">{"MetaDescription"|lang:$component}</label></dt>
            <dd>
                <textarea type="text" id="MetaDescription" name="MetaDescription">{$items_arr[0].MetaDescription|default:''}</textarea>
            </dd>
        </dl>


        <dl>
            <dt><label for="MetaAlt">{"MetaAlt"|lang:$component}</label></dt>
            <dd>
                <input type="text" id="MetaAlt" name="MetaAlt" value="{$items_arr[0].MetaAlt|default:''}"/>
            </dd>
        </dl>
    </fieldset>
</div>