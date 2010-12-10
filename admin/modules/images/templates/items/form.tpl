<script type="text/javascript" src="/js/jquery/plugins/fileuploader/jquery.upload-1.0.2.js"></script>
<div class="form div60_40">
    <form id="EXForm" onsubmit="return false;">
        <input type="hidden" id="RequiredFields" name="RequiredFields" value="{$required}">

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
                <li><a href="#subtab_images">{"Images"|lang:$component}</a></li>
            </ul>
            <div id="subtab_main" class="tab_content">
                {include file="form_main.tpl"}
            </div>
            <div id="subtab_images" class="tab_content">
                {include file="form_images.tpl"}
            </div>
        </div>

    </form>
</div>

{literal}
<script type="text/javascript">
    $(document).ready(function(){
        $('.tabs').tabs({
            load: function(event, ui){
                form_skining(ui.panel);
            },
            show: function(event, ui){
                $(ui.panel).find('.image').each(function(){
                    $(this).hover(function(){
                        $(this).find('.actions').show();
                    }, function(){
                        $(this).find('.actions').hide();
                    });
                });
            }
        });

        initEditor('Content');
        initEditor('Teaser', 'Lite');

        $('input[type=file]').change(function() {
            $(this).upload('/admin/ajax.php?mod={/literal}{$module}{literal}&class={/literal}{$component}{literal}&method=Upload', function(res) {
                if (res['src']){
                    $('<img src="'+res['src']+'" class="image_preview" />').appendTo($('.filesContainer'));
                    $('<input type="hidden" name="src[]" value="'+res['src']+'" />').appendTo($('.filesContainer'));
                }
                var msg = "{/literal}{'File uploaded'|lang:$component}{literal}";
                showNotice(msg);
            }, 'json');
        });

    });
</script>
{/literal}