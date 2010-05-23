    <form method="post" action="javascript:return false;" name="{$component}">
    {$component}
    {*<div class="tableContainer">*}
    {*<table id="{$component}Grid" class="grid">*}
        {*<tr>*}
          {*<th>{$component|cat:"_action"|lang}</th>*}
		  {*<th>{$component|cat:"_ID"|lang}</th>*}
          {*<th>{$component|cat:"_Name"|lang}</th>*}
          {*<th>{$component|cat:"_Description"|lang}</th>*}
          {*<th>{$component|cat:"_Published"|lang}</th>*}
          {*<th>{$component|cat:"_Modified"|lang}</th>*}
          {*<th>{$component|cat:"_Lang"|lang}</th>*}
        {*</tr>*}
      {*<tbody>*}
      {*{foreach from=$items_arr item=item}*}
        {*<tr>*}
          {*<td>*}
            {*<input type="checkbox" name="actionid_{$item.ID}" value="{$item.ID}">*}
          {*</td>*}
		  {*<td>{$item.ID}</td>*}
          {*<td>{$item.Name}</td>*}
          {*<td>{$item.Description|default:"&nbsp;"}</td>*}
          {*<td>*}
			{*{if $item.Published eq "1"}{assign var="pub_ch" value="checked"}{else}{assign var="pub_ch" value=""}{/if}*}
			{*<input type="checkbox" name="published_{$item.ID}" {$pub_ch} value="1" onclick="xajax_categories_publish({$item.ID},this.checked);">*}
		  {*</td>*}
          {*<td>{$item.Modified|date_format:"%d.%m.%Y %H:%M:%S"|default:"&nbsp;"}</td>*}
          {*<td>{$item.Lang}</td>*}
        {*</tr>*}
      {*{/foreach}*}
      {*</tbody>*}
    {*</table>*}
    {*<div class="gridPager"></div>*}
    {*</div>*}
    {grid module=$module class=$component data=$items_arr}
    </form>

