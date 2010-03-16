    <form method="post" action="javascript:return false;" name="modules">
    
    <div class="widget_tableDiv">
    <table id="myTable">
      <thead>
        <tr>
          <td>{lang modules_action}</td>
          <td>{lang modules_caption}</td>
        </tr>
      </thead>
      <tbody class="scrollingContent">
      {foreach from=$modules_arr item=module}
      <tr>
        <td style="height:20px;"><input type="checkbox" name="actionid_{$module.ID}" value="{$module.ID}"></td>
        <td>{$module.Name|lang}</td>
      </tr>
      {/foreach}
      </tbody>
    </table>
    </div>
    </form>
    <script type="text/javascript">
      initTableWidget('myTable',"100%","480",Array(false,'S'));
    </script>