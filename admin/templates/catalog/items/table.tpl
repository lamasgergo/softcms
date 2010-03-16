    <form method="post" action="javascript:return false;" name="{$tab_prefix}">
    
    <div class="widget_tableDiv">
    <table id="myTable">
      <thead>
        <tr>
          <td>{$prefix|cat:"_action"|lang}</td>
		  <td>{$prefix|cat:"_ID"|lang}</td>
          <td>{$prefix|cat:"_Name"|lang}</td>
          <td>{$prefix|cat:"_CategoryID"|lang}</td>
          <td>{$prefix|cat:"_Price"|lang}</td>
          <td>{$prefix|cat:"_Published"|lang}</td>
          <td>{$prefix|cat:"_created"|lang}</td>
        </tr>
      </thead>
      <tbody class="scrollingContent">
      {foreach from=$items_arr item=item}
        <tr>
          <td style="height:20px;"><input type="checkbox" name="actionid_{$item.ID}" value="{$item.ID}"></td>
		  <td>{$item.ID}</td>
          <td>{$item.Name}</td>
          <td>{$item.CategoryID|getCatalogNameById|default:"&nbsp;"}</td>
          <td>{$item.Price|default:"0"}</td>
          <td>
			{if $item.Published eq "1"}{assign var="pub_ch" value="checked"}{else}{assign var="pub_ch" value=""}{/if}
			<input type="checkbox" name="published_{$item.ID}" {$pub_ch} value="1" onclick="items_publish({$item.ID},this.checked);">
		  </td>
          <td>{$item.Created|date_format:"%d.%m.%Y %H:%M:%S"|default:"&nbsp;"}</td>
        </tr>
      {/foreach}
      </tbody>
    </table>
    </div>
    </form>
    <script type="text/javascript">
      initTableWidget('myTable',"100%","480",Array({$sort_table_fields}));
    </script>