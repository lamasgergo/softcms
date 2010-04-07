{if $item_arr}
	<div class="title">{"catalog_items"|lang}</div>

	{foreach from=$item_arr item=item name=list}
	
		{math assign="devider" equation="x % y" x=$smarty.foreach.list.iteration y=$columns }
	
			<div class="item">
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
					<div class="price">
						{if $item.Price ne ""}
							<span class="name">{$moduleName|cat:"_Price"|lang}</span>&nbsp;:&nbsp;
							{math assign="Price" equation="x * y" x=$item.Price y=$currency[$item.PriceUnit]}
							{$Price}&nbsp;{"currency"|lang}
						{/if}
					</div>
					<div>
						{$item.ShortDescription}
					</div>
				</div>
			  </div>
			
			{if $devider eq 0 || $smarty.foreach.list.last}<div class="clr"></div>{/if}
			
		{/foreach}



	{$navigation}

	{mod_stat title="stat_catalog_list" link=$smarty.server.REQUEST_URI}
{/if}