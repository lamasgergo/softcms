<div class="box">
<div class="title">{"Advertise"|lang}</div>
{if count($banners)>0}
	<div id="banners">
	{foreach from=$banners item=item}
		{$item.Code}
	{/foreach}
	</div>
{/if}
</div?