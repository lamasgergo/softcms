<div class="form div60_40">
    <form id="EXForm" onsubmit="return false;">
        <input type="hidden" id="RequiredFields" name="RequiredFields" value="{$required}">

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

        <div class="tabs">
            <ul>
                <li><a href="#subtab_main">{"General"|lang:$component}</a></li>
                <li><a href="#subtab_additional">{"Additional"|lang:$component}</a></li>
            </ul>
            <div id="subtab_main" class="tab_content">
                {include file="form_main.tpl"}
            </div>
            <div id="subtab_additional" class="tab_content">
                {include file="form_additional.tpl"}
            </div>
        </div>


    </form>
</div>
{literal}
<script type="text/javascript">
    $('.tabs').tabs({
        load: function(event, ui) {
            form_skining(ui.panel);
        }
    });
</script>
{/literal}