<div class="search">
	<div class="title">{lang search}</div>
	<div class="sep"></div>
	
	<div class="form">
		<form method="get" action="/{$cur_lang}/search/">
			<input type="text" value="{$smarty.get.text}" size="20" name="text"/> <input type="submit" class="submit" value=" OK "/>
		</form>
	</div>

	{foreach from=$item_arr item=item name=list}
  
		<div class="content">
			<div class="title">
				<div class="text">
					<a href="{get_link link="/index.php?mod=content&iid="|cat:$item.ID}">
						{$item.Title}
					</a>
				</div>
				<div class="date">{$item.Created|date_format:"%d.%m.%Y"}</div>
			</div>
			<div class="text">
				{$item.Short_Text}
			</div>
			<div class="more">
				<a class="dn-read_more" href="{get_link link="/index.php?mod=content&iid="|cat:$item.ID}">{"more"|lang}</a>
			</div>
		</div>
		{if !$smarty.foreach.list.last}
			<div class="sep"></div>
		{/if}
	{/foreach}

	<div class="clr"></div>
	<div class="sep"></div>

	<div id="catalogNavigation">
		{$navigation}
	</div>
</div>

<div class="clr"></div>