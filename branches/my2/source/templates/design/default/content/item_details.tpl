<h3>{$item_arr[0].Title}</h3>

{if $item_arr[0].LoginRequired==1 && !$isAuth}
	<b>{"You have no right to see this content"|lang}</b>
{else}
	{$item_arr[0].Full_Text|regex_replace:"/^\<br\s*\/?\>/":""}
{/if}


<!--
<table class="contentStat">
<tr>
	<td align="right">
	{"Readed"|lang}: {$item_arr[0].ViewCount}<br />
	{"Comments"|lang}: {$item_arr[0].CommentsCount}<br />
	{"Created"|lang}: {$item_arr[0].Created|date_format:"%d-%m-%Y"}
	</td>
</tr>
</table>
-->

{$comments}

{mod_stat title="stat_content" link=$smarty.server.REQUEST_URI description=$item_arr[0].Title}