	<div class="categoryPath">
	  
	  <a href="/">{if !$path}<b>{/if} {lang Homepage} {if !$path}</b>{/if}</a>
	  {if $path} >
		  {foreach from=$path item=path_item name=path}
		    <a href="{$path_item.LinkPath}" {if $smarty.foreach.path.last}class="selected"{/if}>{if $smarty.foreach.path.last}{/if}{$path_item.Name}{if $smarty.foreach.path.last}{/if}</a>
		    {if !$smarty.foreach.path.last} 
		    >
		    {/if}
		  {/foreach}
	  {/if}
	</div>