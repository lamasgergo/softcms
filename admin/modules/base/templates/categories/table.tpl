    <form method="post" action="javascript:return false;" name="{$component}">
    {$component}
    <div class="widget_tableDiv">
    <table id="myTable">
      <thead>
        <tr>
          <td>{$component|cat:"_action"|lang}</td>
		  <td>{$component|cat:"_ID"|lang}</td>
          <td>{$component|cat:"_Name"|lang}</td>
          <td>{$component|cat:"_Description"|lang}</td>
          <td>{$component|cat:"_Published"|lang}</td>
          <td>{$component|cat:"_Modified"|lang}</td>
          <td>{$component|cat:"_Lang"|lang}</td>
        </tr>
      </thead>
      <tbody class="scrollingContent">
      {foreach from=$items_arr item=item}
        <tr>
          <td style="height:20px;"><input type="checkbox" name="actionid_{$item.ID}" value="{$item.ID}"></td>
		  <td>{$item.ID}</td>
          <td>{$item.Name}</td>
          <td>{$item.Description|default:"&nbsp;"}</td>
          <td>
			{if $item.Published eq "1"}{assign var="pub_ch" value="checked"}{else}{assign var="pub_ch" value=""}{/if}
			<input type="checkbox" name="published_{$item.ID}" {$pub_ch} value="1" onclick="xajax_categories_publish({$item.ID},this.checked);">
		  </td>
          <td>{$item.Modified|date_format:"%d.%m.%Y %H:%M:%S"|default:"&nbsp;"}</td>
          <td>{$item.Lang}</td>
        </tr>
      {/foreach}
      </tbody>
    </table>
    </div>
    </form>

