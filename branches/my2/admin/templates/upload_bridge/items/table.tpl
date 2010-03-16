    <form method="post" action="javascript:return false;" name="{$tab_prefix}">
    
    <div class="widget_tableDiv">
    <table id="myTable">
      <thead>
        <tr>
          <td>{$prefix|cat:"_action"|lang}</td>
          <td>{$prefix|cat:"_parent"|lang}</td>
          <td>{$prefix|cat:"_name"|lang}</td>
          <td>{$prefix|cat:"_image"|lang}</td>
          <td>{$prefix|cat:"_created"|lang}</td>
        </tr>
      </thead>
      <tbody class="scrollingContent">
      {foreach from=$items_arr item=item}
        <tr>
          <td style="height:20px;"><input type="checkbox" name="actionid_{$item.ID}" value="{$item.ID}"></td>
          <td>{$item.ParentID}</td>
          <td>{$item.Name}</td>
          <td>{$item.Image}</td>
          <td>{$item.Created|default:"&nbsp;"}</td>
        </tr>
      {/foreach}
      </tbody>
    </table>
    </div>
    </form>
    <script type="text/javascript">
      initTableWidget('myTable',"100%","480",Array({$sort_table_fields}));
    </script>