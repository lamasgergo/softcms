<div class="detail">
  <div class="name">
    {$item_arr.Name}
	<div class="cartadd">
		<a href="#" onClick="addToCart('{$item_arr.ID}');">
			<img src="{$design_images}/cartadd.png" border="0" />
		</a>
	</div>    
  </div>
  <div class="body">
    <div class="images">
        {show_image origLink="true" dir=$uploadDir dirURL=$uploadDirURL group=$item_arr.ImageGroupID class="im"}
    </div>
    <div class="desc">
		<div class="price">
			{if $item_arr.Price ne ""}
				<span class="name">{$mod_name|cat:"_Price"|lang}</span>&nbsp;:&nbsp;
				{math assign="Price" equation="x * y" x=$item_arr.Price y=$currency[$item_arr.PriceUnit]}
				{$Price}&nbsp;{"currency"|lang}
			{/if}
		</div>
    </div>
	<div class="description">
		{$item_arr.Description}
	</div>
  </div>
</div>


{catalog_item_count id=$item_arr.ID}

{capture name="details"}
  {if $item_arr.Price ne ""}
  	{math assign="Price" equation="x * y" x=$item_arr.Price y=$currency[$item_arr.PriceUnit]}
	{$Price} &nbsp;{"currency"|lang}
  	
  {/if}
{/capture}

{mod_stat title="catalog_details" link=$smarty.server.REQUEST_URI description=$smarty.capture.details}