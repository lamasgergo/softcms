    <form method="post" action="javascript:return false;" name="{$component}">
      {$component}
    <div class="widget_tableDiv">
    <table id="myTable">
      <thead>
        <tr>
          <td>{$component|cat:"_action"|lang}</td>
		  <td>{$component|cat:"_ID"|lang}</td>
          <td>{$component|cat:"_Title"|lang}</td>
          <td>{$component|cat:"_CategoryID"|lang}</td>
          <td>{$component|cat:"_Published"|lang}</td>
          <td>{$component|cat:"_Updated"|lang}</td>
          <td>{$component|cat:"_Lang"|lang}</td>
        </tr>
      </thead>
      <tbody class="scrollingContent">
      {foreach from=$items_arr item=item}
        <tr>
          <td style="height:20px;"><input type="checkbox" name="actionid_{$item.ID}" value="{$item.ID}"></td>
		  <td>{$item.ID}</td>
          <td>{$item.Title}</td>
          <td>{$item.CategoryID|ShowCntCategory|default:"&nbsp;"}</td>
          <td>
			{if $item.Published eq "1"}{assign var="pub_ch" value="checked"}{else}{assign var="pub_ch" value=""}{/if}
			<input type="checkbox" name="published_{$item.ID}" {$pub_ch} value="1" onclick="items_publish({$item.ID},this.checked);">
		  </td>
          <td>{$item.Modified|date_format:"%d.%m.%Y %H:%M:%S"|default:"&nbsp;"}</td>
          <td>{$item.Lang}</td>
        </tr>
      {/foreach}
      </tbody>
    </table>
    </div>
    </form>
    <script type="text/javascript">
      initTableWidget('myTable',"100%","480",Array({$sort_table_fields}));
    </script>