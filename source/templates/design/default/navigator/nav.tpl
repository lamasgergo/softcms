<div class="navigation">

	<div class="center">

		<div class="navItems">
			{"Page"|lang}
		</div>
		
		{if $startLink}
			<div class="navPrevBlock">
				<a href="{$startLink}" class="navPrev">{"Prev page"|lang}</a>
			</div>
		{else}
			<div class="navPrevBlock">
				<span class="navPrev">{"Prev page"|lang}</span>
			</div>
		{/if}
		  
		<div class="navPages">

			{foreach from=$nav_arr item=item name=list}
				<div class="block">
					{$item}
				</div>
			{/foreach}
		</div>
		
		{if $endLink}
			<div class="navNextBlock">
			  <a href="{$endLink}" class="navNext">{"Next page"|lang}</a>
			</div>
		{else}
			<div class="navNextBlock">
				<span class="navNext">{"Next page"|lang}</span>
			</div>
		{/if}

	</div>
		
    <div class="clr"></div>
</div>