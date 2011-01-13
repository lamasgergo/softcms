<input type="hidden" id="RequiredFields" name="RequiredFields[]" value="{$required}">
<input type="hidden" name="FieldsInfo[]" value="{$field_types}">
<div>
    <fieldset>
        <legend>{"Additional data"|lang:$component}</legend>

        <dl>
            <dt><label for="Familyname">{"Familyname"|lang:$component}</label></dt>
            <dd>
                <input type="text" id="Familyname" name="Familyname" value="{$items_arr[0].Familyname|default:''}">
            </dd>
        </dl>

        <dl>
            <dt><label for="Patronymic">{"Patronymic"|lang:$component}</label></dt>
            <dd>
                <input type="text" id="Patronymic" name="Patronymic" value="{$items_arr[0].Patronymic|default:''}">
            </dd>
        </dl>

        <dl>
            <dt><label for="Country">{"Country"|lang:$component}</label></dt>
            <dd>
                <input type="text" id="Country" name="Country" value="{$items_arr[0].Country|default:''}">
            </dd>
        </dl>

        <dl>
            <dt><label for="City">{"City"|lang:$component}</label></dt>
            <dd>
                <input type="text" id="City" name="City" value="{$items_arr[0].City|default:''}">
            </dd>
        </dl>

        <dl>
            <dt><label for="Address">{"Address"|lang:$component}</label></dt>
            <dd>
                <textarea id="Address" name="Address">{$items_arr[0].Address|default:''}</textarea>
            </dd>
        </dl>

        <dl>
            <dt><label for="Address2">{"Address2"|lang:$component}</label></dt>
            <dd>
                <textarea id="Address2" name="Address2">{$items_arr[0].Address2|default:''}</textarea>
            </dd>
        </dl>

        <dl>
            <dt><label for="ZIP">{"ZIP"|lang:$component}</label></dt>
            <dd>
                <input type="text" id="ZIP" name="ZIP" value="{$items_arr[0].ZIP|default:''}">
            </dd>
        </dl>

        <dl>
            <dt><label for="Phone">{"Phone"|lang:$component}</label></dt>
            <dd>
                <input type="text" id="Phone" name="Phone" value="{$items_arr[0].Phone|default:''}">
            </dd>
        </dl>

        <dl>
            <dt><label for="Cellphone">{"Cellphone"|lang:$component}</label></dt>
            <dd>
                <input type="text" id="Cellphone" name="Cellphone" value="{$items_arr[0].Cellphone|default:''}">
            </dd>
        </dl>

    </fieldset>
</div>