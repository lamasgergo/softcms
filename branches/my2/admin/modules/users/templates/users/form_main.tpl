<input type="hidden" id="RequiredFields" name="RequiredFields[]" value="{$required}">
<input type="hidden" name="FieldsInfo[]" value="{$field_types}">
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

        <dl>
            <dt><label for="Name">{"Name"|lang:$component}</label></dt>
            <dd>
                <input type="text" id="Name" name="Name" value="{$items_arr[0].Name|default:''}">
            </dd>
        </dl>

        <dl>
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
                {html_checkbox name="Published" id="Published" selected=$items_arr[0].Published value="1" default="0"}
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