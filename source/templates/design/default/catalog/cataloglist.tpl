{if $item_arr}

	<div class="title">{"catalog_categories"|lang}</div>

	{foreach from=$item_arr item=item name=list}
		
		{math assign="devider" equation="x % y" x=$smarty.foreach.list.iteration y=$columns }
	
		<div class="item">
			<div class="name">
				<a href="{catalog_link category=$item.ID}">{$item.Name}</a>
			</div>
			{if $item.ImageGroupID && $showCategoryImages}
				<div class="image">
					{show_image dir=$uploadDir dirURL=$uploadDirURL group=$item.ImageGroupID class="im"}
				</div>
			{/if}
			{if $showSubCategories}
				<div class="subcatalog">          
				  {foreach from=$subcatalogs_arr[$item.ID] item=citem name=clist}
					<a href="{catalog_link category=$citem.ID}">{$citem.Name}</a>
					{if !$smarty.foreach.clist.last}
					&nbsp;|&nbsp;
					{/if}
				  {/foreach}
				</div>
			{/if}
		  </div>
		  
		{if $devider eq 0 || $smarty.foreach.list.last}<div class="clr"></div>{/if}
		
	{/foreach}
{/if}