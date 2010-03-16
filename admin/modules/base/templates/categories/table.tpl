    <form method="post" action="javascript:return false;" name="{$component}">
    
    <div class="widget_tableDiv">
    <table id="myTable">
      <thead>
        <tr>
          <td>{$module|cat:"_action"|lang}</td>
		  <td>{$module|cat:"_ID"|lang}</td>
          <td>{$module|cat:"_name"|lang}</td>
          <td>{$module|cat:"_description"|lang}</td>
          <td>{$module|cat:"_published"|lang}</td>
          <td>{$module|cat:"_modified"|lang}</td>
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
          <td>{$item.Modified}</td>
        </tr>
      {/foreach}
      </tbody>
    </table>
    </div>
    </form>
    <script type="text/javascript">
      initTableWidget('myTable',"100%","480",Array({$sort_table_fields}));
    </script>