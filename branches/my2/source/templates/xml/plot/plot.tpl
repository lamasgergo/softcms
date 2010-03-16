<items>
{foreach from=$item_arr item=item}
	<item index="{$item.Num}" reserved="{if $item.Reserved==1}true{else}false{/if}"/>
{/foreach}
</items>