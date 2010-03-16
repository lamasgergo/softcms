{assign var="i" value="0"}

<table width="100%" cellspacing="0" cellpadding="0" border="0">
{foreach from=$item_arr item=item}
	<tr align="left" class="menuclass-{$i}">
		<td>
			<a {if $item.current}id="active_menu"{/if} class="mainlevel" href="{$item.link}">{$item.name}</a>
		</td>
	</tr>
	
	{if $i==1}
		{assign var="i" value="0"}
	{else}
		{assign var="i" value="1"}
	{/if}
	
{/foreach}
</table>