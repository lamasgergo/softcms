<div id="contentMenu" class="ui-accordion ui-widget ui-helper-reset" role="tablist">
{foreach from=$item_arr item=item name="menu"}
	<h3 title="{$item.Name}" class="ui-accordion-header ui-helper-reset {if $smarty.server.REQUEST_URI==$item.Link}ui-state-active{else}ui-state-default{/if} ui-corner-all" role="tab" aria-expanded="false" tabindex="-1">
		<a href="{$item.Link}">
			<div>{$item.Name}</div>
		</a>
	</h3>
{/foreach}
</div>