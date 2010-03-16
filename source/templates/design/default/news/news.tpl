<h3>{"World News"|lang}</h3>
 
<div class="dn-whole">
{foreach from=$news_arr item=item name=list}
	<div class="dn-each">
		<span class="dn-date">{$item.pubDate|date_format:"%d.%m.%Y"}</span>
		<br/>
		<span class="dn-title">
			<a class="dn-title" target="_blank" href="{$item.link}">
				{$item.title}
			</a>
		</span>
		<br/><span class="dn-introtext">
			{$item.description}
		</span>
		<span class="dn-read_more">
			<a class="dn-read_more" target="_blank" href="{$item.link}">{"more"|lang}</a>
		</span>
	</div>
{/foreach}
</div>