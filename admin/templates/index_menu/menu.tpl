<div id="menu_top">
	<div class="item"><a href="/admin/"><img src="/source/images/icons/home.png" border="0"></a></div>
	<div class="top_menu">
          {foreach from=$modules item=module}
            <a href="index.php?mod={$menu.Link}">
				<div class="item">
					{$module.Name|lang|replace:"<br>":" "}
				</div>
			</a>
          {/foreach}
	</div>

	<div class="user">({$user.Name})&nbsp;<a href="{mod_admin_common_link value='logout'}" style="color:black;">{lang logout}</a></div>
    <div class="lang">
	    <select onChange='change_edit_lang(this.value);'>
		{foreach from=$langList key=lang item=lang_desc}
            <option value="{$lang}">{$lang_desc}</option>
		{/foreach}
		</select>
	</div>
</div>