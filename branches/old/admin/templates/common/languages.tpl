{assign var="i" value="1"}
{foreach from=$lang_list key="lang_key" item="lang"}
	<div style="background: url({$images}/icons/selected_lang{if $cur_lang==$i}_over{/if}.gif) 0% 30% no-repeat; height: 35px; width: 35px; text-align: center;" >
		<input type='image' style='margin: 12px 0px 0px 3px;' src='{$images}/flags/{$lang_key}.gif' border='0' onclick='xajax_change_edit_lang({$i});'>
	</div>
	{assign var="i" value=$i+1}
{/foreach}