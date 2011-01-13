<div class="form div60_40">
    <form id="EXForm" onsubmit="return false;">
        <div class="action">
            <fieldset class="action">
                <input type="hidden" id="ID" name="ID" value="{$items_arr[0].ID}">
                <input type="hidden" id="tab_name" name="tab_name" value="{$tab_name}">
                <input type="hidden" id="tab_id" name="tab_id" value="{$tab_id}">
                {include file="/admin/buttons/save_apply.tpl"}
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
                {$additional_form}
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