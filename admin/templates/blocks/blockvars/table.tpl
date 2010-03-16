    <form method="post" action="javascript:return false;" name="{$tab_prefix}">
    
    <div class="widget_tableDiv">
    <table id="myTable">
      <thead>
        <tr>
          <td>{$prefix|cat:"_action"|lang}</td>
          <td>{$prefix|cat:"_block"|lang}</td>
          <td>{$prefix|cat:"_module"|lang}</td>
          <td>{$prefix|cat:"_params"|lang}</td>
          <td>{$prefix|cat:"_blockname"|lang}</td>
          <td>{$prefix|cat:"_blockorder"|lang}</td>
        </tr>
      </thead>
      <tbody class="scrollingContent">
      {foreach from=$items_arr item=item}
        <tr>
          <td style="height:20px;"><input type="checkbox" name="actionid_{$item.ID}" value="{$item.ID}"></td>
          <td>{$item.BlocksID|getBlockName}</td>
          <td>{$item.Module|lang}</td>
          <td>{$item.Params|default:"&nbsp;"}</td>
          <td>{$item.BlockName|default:"&nbsp;"}</td>
          <td>{$item.BlockOrder}</td>
        </tr>
      {/foreach}
      </tbody>
    </table>
    </div>
    </form>
    <script type="text/javascript">
      initTableWidget('myTable',"100%","480",Array({$sort_table_fields}));
    </script>