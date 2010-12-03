<div class="left">
    <fieldset>
        <legend>{"Accound data"|lang:$component}</legend>

        <dl>
            <dt><label for="Login">{"Login"|lang:$component}</label></dt>
            <dd>
                <input type="text" id="Login" name="Login" value="{$items_arr[0].Login|default:''}">
            </dd>
        </dl>

        <dl>
            <dt><label for="Password">{"Password"|lang:$component}</label></dt>
            <dd>
                <input type="password" id="Password" name="Password">
            </dd>
        </dl>

        <dl class="line">
            <dt><label for="Name">{"Name"|lang:$component}</label></dt>
            <dd>
                <input type="text" id="Name" name="Name" value="{$items_arr[0].Name|default:''}">
            </dd>
        </dl>

        <dl class="line">
            <dt><label for="Email">{"Email"|lang:$component}</label></dt>
            <dd>
                <input type="text" id="Email" name="Email" value="{$items_arr[0].Email|default:''}">
            </dd>
        </dl>
    </fieldset>
</div>
<div class="right">
    <fieldset>
        <legend>{"General"|lang:$component}</legend>

        <dl>
            <dt><label for="Group">{"Group"|lang:$component}</label></dt>
            <dd>
                <select name="Group" id="Group">
                    <option value="">{"-- Select --"|lang}</option>
                    {html_options options=$groups selected=$items_arr[0].Group|default:''}
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
            <dt><label for="Lang">{"Lang"|lang:$component}</label></dt>
            <dd>
                <select name="Lang" id="Lang">
                    <option value="">{"-- Select --"|lang}</option>
                    {html_options options=$langs selected=$items_arr[0].Lang|default:''}
                </select>
            </dd>
        </dl>

        <dl>
            <dt><label for="EditLang">{"EditLang"|lang:$component}</label></dt>
            <dd>
                <select name="EditLang" id="EditLang">
                    <option value="">{"-- Select --"|lang}</option>
                    {html_options options=$langs selected=$items_arr[0].EditLang|default:''}
                </select>
            </dd>
        </dl>

    </fieldset>
</div>