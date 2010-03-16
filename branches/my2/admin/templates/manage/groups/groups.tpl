    <form method="post" action="javascript:return false;" name="groups">
    
    <div id="visual_groups" class="widget_tableDiv">
    <table id="myTable">
      <thead>
        <tr>
          <td>{lang groups_action}</td>
          <td>{lang groups_caption}</td>
        </tr>
      </thead>
      <tbody class="scrollingContent">
      {foreach from=$groups item=group_item}
      <tr>
        <td style="height:20px;"><input type="checkbox" name="actionid_{$group_item.ID}" value="{$group_item.ID}"></td>
        <td onClick="refresh_users({$group_item.ID});showTab('dhtmlgoodies_tabView1',1);" style="cursor:hand; text-decoration:underline;">{$group_item.Name}</td>
      </tr>
      {/foreach}
      </tbody>
    </table>
    </div>
    </form>
    <script type="text/javascript">
      initTableWidget('myTable',"100%","480",Array(false,'S'));
    </script>