<div id="menu_top">
  
	{literal}
		<script>
			$(document).ready(function(){
				$('ul.jd_menu').jdMenu();
			});
		</script>
	{/literal}
  
	<div class="menu">
		<ul class="jd_menu">
			<li>
				<a href="/admin/">
				<img src="{$images}/icons/home.png" border="0">&nbsp;
				</a>
			</li>
			{foreach from=$modules key=group item=moduleItems}
				<li>
					{$group}
					<ul>
					{foreach from=$moduleItems item=module}
						<li>
							<a href="/admin/index.php?mod={$module.Link}">{$module.Name}</a>
						</li>
					{/foreach}
					</ul>
				</li>
			{/foreach}
		</ul>
	</div>
  
	<div class="moduleTitle">
		{$smarty.get.mod|lang}
	</div>
  
	<div class="user">
		({$username})&nbsp;<a href="{mod_admin_common_link value='logout'}" style="color:black;">{lang logout}</a>
	</div>
  
	<div class="right">
		
		<div class="lang">
			<table>
			<tr>
				<td>{"GUILang"|lang}:</td>
				<td>
					<select name="GUILang">
						{foreach from=$langs key=lang item=langName}
							<option value="{$lang}" {if $lang == $GUILang} selected{/if}>{$langName}</option>
						{/foreach}
					</select>
				</td>
			</tr>
			<tr>
				<td>{"ContentLang"|lang}:</td>
				<td>
					<select name="ContentLang">
						{foreach from=$langs key=lang item=langName}
							<option value="{$lang}" {if $lang == $ContentLang} selected{/if}>{$langName}</option>
						{/foreach}
					</select>
				</td>
			</tr>
			</table>
		</div>
	</div>
	
</div>