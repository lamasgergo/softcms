
{assign var="total" value="0"}
<div id="cart"
	<form id="EXForm" method="POST"> 
		<table class="checkout_table">
		<tr>
			<th>{'cart_item'|lang}</th>
			<th>{'cart_id'|lang}</th>
			<th>{'cart_Price'|lang}</th>
			<th>{'cart_count'|lang}</th>
			<th>{'cart_sum'|lang}</th>
		</tr>
		{foreach from=$item_arr item="item"}
			<tr>
				<td>{$item.Name}</td>
				<td>{$item.ID}</td>
				<td>{$item.Price}</td>
				<td>{$item.Count}</td>
				<td>{$item.Sum}</td>
			</tr>
		{/foreach}
		<tr>
			<td colspan="5" align="right">{"cart_total"|lang}</td>
			<td>{$total}</td>
		</tr>
		</table>
	</form>
</div>