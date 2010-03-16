{literal}
<script>

	function calcTotal(){
		var total = 0;
			$('.checkout_table').find('[id^=cart_item_]').each(function(){
				var price = parseInt($(this).find('#item_total_price').html());
				if (!isNaN(price)){
					total = total+price;
				}
			});
			$('#total_price').html(total);
	}

	function updateCart(id, count){
		if (count > 0){
			cart_update(id, count);
			cart_refresh();
			var row_price = $('#cart_item_'+id).find('#item_price').html();
			$('#cart_item_'+id).find('#item_total_price').html(count*row_price);
			calcTotal();
		}
	}
	function removeCart(id){
		$('.checkout_table').find('#cart_item_'+id).remove();
		cart_remove(id);
		cart_refresh();
		calcTotal();
	}
</script>
{/literal}

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
			<th>{'cart_remove'|lang}</th>
		</tr>
		{foreach from=$item_arr item="item"}
			<tr id="cart_item_{$item.ID}">
				<td>{$item.Name}</td>
				<td>{$item.ID}</td>
				<td><span id="item_price">{$item.Price}</span>&nbsp;{"currency"|lang}</td>
				<td><input type="text" id="count" name="Count_{$item.ID}" value="{$item.Count}" class="form_item" style="width: 30px; !important;" onKeyUp="updateCart('{$item.ID}', this.value)" \></td>
				<td><span id="item_total_price">{$item.Sum}</span>&nbsp;{"currency"|lang}</td>
				<td><input type="checkbox" name="remove" value="{$item.ID}" onClick="removeCart('{$item.ID}')"  style="width: 30px; !important;"/></td>
			</tr>
			{math equation="x+y" x=$total y=$item.Sum assign=total}
		{/foreach}
		{if $total > 0}
		<tr>
			<td colspan="5" align="right">{"cart_total"|lang}</td>
			<td><span id="total_price">{$total}</span>&nbsp;{"currency"|lang}</td>
		</tr>
		{/if}
		</table>
	</form>
</div>

<hr />
{if !$is_auth && $step==1}
<div id="error">{$error}</div>
<form name="EXForm" id="EXForm" method="POST">
<table id="cart_reg" border="0" cellpadding="3" cellspacing="0" class="content" style="padding:10px; width: 100%;">
<tr>
	<td width="100%">
		<table border="0" cellpadding="5" cellspacing="0" class="content">
		<tr>
			<td width="150">{lang cart_Login}</td>
			<td>
				<input type="text" name="Login" id="Login" class="form_item" >
			</td>
		</tr>
		<tr>
			<td width="150">{lang cart_Email}</td>
			<td>
				<input type="text" name="Email" id="Email" class="form_item" >
			</td>
		</tr>
		<tr>
			<td width="150">{lang cart_Password}</td>
			<td>
				<input type="text" name="Password" id="Password" class="form_item" >
			</td>
		</tr>
		<tr>
			<td width="150">{lang cart_Password_repeat}</td>
			<td>
				<input type="text" name="password_repeat" id="password_repeat" class="form_item" >
			</td>
		</tr>
		<tr>
			<td width="150">{lang cart_Name}</td>
			<td>
				<input type="text" name="Name" id="Name" class="form_item" >
			</td>
		</tr>
		<tr>
			<td width="150">{lang cart_Familyname}</td>
			<td>
				<input type="text" name="name" id="name" class="form_item" >
			</td>
		</tr>
		<tr>
			<td width="150">{lang cart_Address}</td>
			<td>
				<textarea name="Address" id="Address" class="form_area" rows="5"></textarea>
			</td>
		</tr>
		<tr>
			<td width="150">{lang cart_Phone}</td>
			<td>
				<input type="text" name="Phone" id="Phone" class="form_item" >
			</td>
		</tr>
		
		</table>
	</td>
</tr>
<tr>
	<td align="right"><input type="submit" name="submit_buy" id="submit_buy" value="{lang cart_buy}" class="form_but" style="width: 130px;"></td>
</tr>
</table>
</form>

{/if}