<div class="content newsflash">

	<div class="box">
		<div class="title">{"News"|lang}</div>
		<div class="body">
			{foreach from=$item_arr item=item name=list}
				<div class="news">
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
			{/foreach}
		</div>
	</div>
	
</div>