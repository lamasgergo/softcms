    <form method="post" action="javascript:return false;" name="{$tab_prefix}">
    
    <div class="widget_tableDiv">
    <table id="myTable">
      <thead>
        <tr>
          <td>{$prefix|cat:"_title"|lang}</td>
          <td>{$prefix|cat:"_link"|lang}</td>
          <td>{$prefix|cat:"_descritption"|lang}</td>
          <td>{$prefix|cat:"_visited"|lang}</td>
          <td>{$prefix|cat:"_cnt"|lang}</td>
        </tr>
      </thead>
      <tbody class="scrollingContent">
      {foreach from=$items_arr item=item}
        <tr>
          <td>{$item.Title|lang}</td>
          <td><a href={$item.Link} target="_blank">{$item.Link}</a></td>
          <td>{$item.Description|default:"&nbsp;"}</td>
          <td>{$item.Visited}</td>
          <td>{$item.cnt}</td>
        </tr>
      {/foreach}
      </tbody>
    </table>
    </div>
    </form>
    <script type="text/javascript">
      initTableWidget('myTable',"100%","480",Array({$sort_table_fields}));
    </script>