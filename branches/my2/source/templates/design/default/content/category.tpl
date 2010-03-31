<h2>{$details[0].Name}</h2>

{if $item_arr[0].LoginRequired==1 && !$isAuth}
			<b>{"You have no right to see this content"|lang}</b>
{else}
			
	<table border="0" cellpadding="5" cellspacing="0" class="contentTable">
	  {foreach from=$item_arr item=item name=list}
	  <tr valign="top">
	    <td class="title">
	      <a href="{get_link link="/index.php?mod=content&iid="|cat:$item.ID}">{$item.Title}</a>
	    </td>
	  </tr>
	  <tr>
	    <td>
	      {$item.Short_Text}
	    </td>
	  </tr>
	  {if !$smarty.foreach.list.last}
	  <tr>
	  	<td><div class="sep"></div></td>
	  </tr>
	  {/if}
	  {/foreach}
	</table>
	<div class="clr"></div>
	<div class="sep"></div>
	<div id="catalogNavigation">
	{$navigation}
	</div>
	
{/if}