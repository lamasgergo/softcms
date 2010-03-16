    <form method="post" action="javascript:return false;" name="{$tab_prefix}">
    
    <div class="widget_tableDiv">
    <table id="myTable">
      <thead>
        <tr>
          <td>{$prefix|cat:"_action"|lang}</td>
		  <td>{$prefix|cat:"_ID"|lang}</td>
		  <td>{$prefix|cat:"_CategoryID"|lang}</td>
          <td>{$prefix|cat:"_Name"|lang}</td>
          <td>{$prefix|cat:"_Price"|lang}</td>
          <td>{$prefix|cat:"_Status"|lang}</td>
          <td>{$prefix|cat:"_AucDate"|lang}</td>
          <td>{$prefix|cat:"_created"|lang}</td>
        </tr>
      </thead>
      <tbody class="scrollingContent">
      {foreach from=$items_arr item=item}
        <tr>
          <td style="height:20px;"><input type="checkbox" name="actionid_{$item.ID}" value="{$item.ID}"></td>
		  <td>{$item.ID}</td>
		  <td>{$item.CategoryID|getMotoAucCatalogNameById|default:"&nbsp;"}</td>
          <td>{$item.Name}</td>
          <td>{$item.Price|default:"0"}</td>
          <td>
			{$prefix|cat:"_"|cat:$item.Status|lang}
		  </td>
          <td>{$item.StartDate} - {$item.EndDate}</td>
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