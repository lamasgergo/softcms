    <div id="visual_modules" class="widget_tableDiv">
    <table id="myTable">
      <thead>
        <tr>
          <td>{lang per_choose}</td>
          <td>{lang per_modules}</td>
        </tr>
      </thead>
      <tbody class="scrollingContent">
      {foreach from=$modules item=modules_item}
      <tr>
        <td style="height:20px;"><input type="radio" name="moduleid" id="moduleid" value="{$modules_item.ID}" onclick="document.getElementById('sel_moduleid').value=this.value;show_groups(this.checked);"></td>
        <td>{$modules_item.Name|lang}</td>
      </tr>
      {/foreach}
      </tbody>
    </table>
    </div>
    <script type="text/javascript">
      initTableWidget('myTable',"270","300",Array('S'));
    </script>