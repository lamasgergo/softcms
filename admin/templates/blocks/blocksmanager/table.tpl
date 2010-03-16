    <form method="post" action="javascript:return false;" name="{$tab_prefix}">
    
    <div class="widget_tableDiv">
    <table id="myTable">
      <thead>
        <tr>
          <td>{$prefix|cat:"_action"|lang}</td>
          <td>{$prefix|cat:"_name"|lang}</td>
          <td>{$prefix|cat:"_design"|lang}</td>
          <td>{$prefix|cat:"_module"|lang}</td>
          <td>{$prefix|cat:"_modulespec"|lang}</td>
          <td>{$prefix|cat:"_moduledefault"|lang}</td>
          <td>{$prefix|cat:"_getadd"|lang}</td>
        </tr>
      </thead>
      <tbody class="scrollingContent">
      {foreach from=$items_arr item=item}
        <tr>
          <td style="height:20px;"><input type="checkbox" name="actionid_{$item.ID}" value="{$item.ID}"></td>
          <td><a href="#" onClick="blockvars_refresh(1,{$item.ID}); return false;">{$item.Name}</a></td>
          <td>{$item.DesignID|ShowDesign}</td>
          <td>{$item.Module|default:"&nbsp;"}</td>
          <td>{$item.ModuleSpec|default:"&nbsp;"}</td>
          <td>{$item.Module_default}</td>
          <td>{$item.GetAdd|default:"&nbsp;"}</td>
        </tr>
      {/foreach}
      </tbody>
    </table>
    </div>
    </form>
    <script type="text/javascript">
      initTableWidget('myTable',"100%","480",Array({$sort_table_fields}));
    </script>