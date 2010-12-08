<div id="menu_top">
	<div class="item"><a href="/admin/"><img src="/admin/icons/home.png" border="0"></a></div>
	<div class="top_menu">
          {foreach from=$modules item=module}
            <a href="index.php?mod={$module.Name}">
				<div class="item">
				    <div class="icon">
				    <img border="0" height="32" src="/admin/modules/{$module.Name}/images/{$module.Name}32x32.png" />
				    </div>
				    <div>
					{$module.Name|lang:'ADMIN_MENU'|replace:"<br>":" "}
					</div>
				</div>
			</a>
          {/foreach}
	</div>

	<div class="user">({$user.Name})&nbsp;<a href="/admin/logout.php" style="color:black;">{"Logout"|lang}</a></div>
    <div class="lang">
	    <select onChange='change_edit_lang(this.value);'>
		{foreach from=$langList key=lang item=lang_desc}
            <option value="{$lang}">{$lang_desc}</option>
		{/foreach}
		</select>
	</div>
</div>