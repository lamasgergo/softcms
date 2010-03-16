<div id="search">
	<div class="box">
		<div class="title">{lang search}</div>
		
			<form method="get" action="/index.php">
				<input type="hidden" value="search" name="mod"/> 
				<input type="text" value="{$smarty.get.text}" name="text"/> 
				<select name="mode">
					<option value="catalog" {if $smarty.get.mode=='catalog'}selected{/if}>{"search_catalog"|lang}</option>
					<option value="content" {if $smarty.get.mode=='content'}selected{/if}>{"search_content"|lang}</option>
				</select>
				<input type="submit" value="OK" class="button" />
		</form>
	</div>
</div>