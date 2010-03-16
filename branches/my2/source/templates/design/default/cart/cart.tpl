
{assign var="total" value="0"}

<div id="cart_block">
<div id="cart">
<div class="box">
	<div class="title">{lang cart}</div>
	<form id="EXForm" method="POST"> 
		{if count($item_arr)>0}
		<table class="checkout_table">
		{foreach from=$item_arr item="item"}
			<tr id="cart_item_{$item.ID}">
				<td>{$item.Name}</td>
				<td>{$item.Count}</td>
				<td>{$item.Price}&nbsp;{"currency"|lang}</td>
			</tr>
			{math equation="x+y" x=$total y=$item.Sum assign=total}
		{/foreach}
		{else}
			{"cart_empty"|lang}
		{/if}
		{if $total > 0}
		<tr>
			<td colspan="2" align="right">{"cart_total"|lang}</td>
			<td>{$total}&nbsp;{"currency"|lang}</td>
		</tr>
		{/if}
		</table>
		<div style="text-align: right;">
			<img src="{$design_images}/checkout.png" onClick="location.href='{get_link link="index.php?mod=cart&checkout&"}';">
		</div>
	</form>
	</div>
</div>
</div>