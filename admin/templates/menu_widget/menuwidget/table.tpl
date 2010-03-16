<script type="text/javascript" src="{$js}/sort_table.js"></script>
<link type="text/css" rel="StyleSheet" href="{$css}/sort_table.css" />

    <table id="myTable">
      <thead>
        <tr>
          <td>{$prefix|cat:"_action"|lang}</td>
          <td>{$prefix|cat:"_name"|lang}</td>
          <td>{$prefix|cat:"_link"|lang}</td>
          <td>{$prefix|cat:"_ordernum"|lang}</td>
          <td>{$prefix|cat:"_created"|lang}</td>
        </tr>
      </thead>
      <tbody class="scrollingContent">
      {foreach from=$items_arr item=item}
        <tr>
          <td style="height:20px;"><input type="checkbox" name="actionid_{$item.ID}" value="{$item.ID}"></td>
          <td>{$item.Name}</td>
          <td>{$item.Link}</td>
          <td>{$item.OrderNum}</td>
          <td>{$item.Created|default:"&nbsp;"}</td>
        </tr>
      {/foreach}
      </tbody>
    </table>
    <script type="text/javascript">
      initTableWidget('myTable',"100%","480",Array({$sort_table_fields}));
    </script>