{if count($banners)>0}
	<div id="banners">
	{foreach from=$banners item=item}
		{$item.Code}
	{/foreach}
	</div>
{/if}
