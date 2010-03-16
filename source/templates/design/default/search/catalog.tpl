<div class="search">
	<div class="title">{lang search}</div>
	<div class="sep"></div>
	
	<div class="form">
		<form method="get" action="/{$cur_lang}/search/">
			<input type="text" value="{$smarty.get.text}" size="20" name="text"/> <input type="submit" class="submit" value=" OK "/>
		</form>
	</div>

	{foreach from=$item_arr item=item name=list}
  
		<div class="catalog">
				<div class="name">
					<a href="{catalog_link item=$item.ID}">{$item.Name}</a>
				
					<div class="addcart">
						<a href="#" onClick="addToCart('{$item.ID}');">
							<img src="{$design_images}/addcart.png" border="0" />
						</a>
					</div>    
				</div>
				
				<div class="image">
					<a href="{catalog_link item=$item.ID}">
						{show_image dir=$uploadDir dirURL=$uploadDirURL group=$item.ImageGroupID class="im"}
					</a>
				</div>
				
				<div class="desc">
					<div>
						{$item.Description}
					</div>
				</div>
		</div>
		  
		<div class="clr"></div>
	{/foreach}

	<div class="clr"></div>
	<div class="sep"></div>

	{$navigation}
</div>

<div class="clr"></div>