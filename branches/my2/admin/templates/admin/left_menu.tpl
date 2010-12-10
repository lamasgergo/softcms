<ul class="menu ui-tabs-panel ui-widget-content ui-corner-top">
    <li class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top {if $smarty.get.mod==''}ui-state-active{/if}">
        <a href="/admin/">
            {"Dashboard"|lang:'ADMIN_MENU'|replace:"<br>":" "}
        </a>
    </li>
    {foreach from=$modules item=module}
        <li class="ui-helper-reset ui-helper-clearfix ui-widget-header {if $smarty.get.mod==$module.Name}ui-state-active{/if}">
            <a href="index.php?mod={$module.Name}">
                {$module.Name|lang:'ADMIN_MENU'|replace:"<br>":" "}
            </a>
        </li>
    {/foreach}
</ul>
