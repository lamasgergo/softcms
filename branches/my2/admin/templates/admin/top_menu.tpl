<div class="menu">
    <a href="/admin/">
        <div class="item ui-corner-top {if $smarty.get.mod==''}ui-state-active{else}ui-state-default{/if}">{"Dashboard"|lang:'ADMIN_MENU'|replace:"<br>":" "}</div>
    </a>
    {foreach from=$modules item=module}
        <a href="index.php?mod={$module.Name}">
            <div class="item ui-corner-top {if $smarty.get.mod==$module.Name}ui-state-active{else}ui-state-default{/if}">
                {$module.Name|lang:'ADMIN_MENU'|replace:"<br>":" "}
            </div>
        </a>
    {/foreach}
</div>

<div class="user">({$user.Name})&nbsp;<a href="/admin/logout.php">{"Logout"|lang}</a></div>
<div class="lang">
    <select onChange='change_edit_lang(this.value);'>
        {foreach from=$langList key=lang item=lang_desc}
        <option value="{$lang}">{$lang_desc}</option>
        {/foreach}
    </select>
</div>
