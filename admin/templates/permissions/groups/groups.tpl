    <div id="visual_modules" class="widget_tableDiv">
    <table id="myTable">
      <thead>
        <tr>
          <td>{lang per_choose}</td>
          <td>{lang per_group}</td>
        </tr>
      </thead>
      <tbody class="scrollingContent">
      {foreach from=$groups item=groups_item}
      <tr>
        <td style="height:20px;"><input type="radio" id="groupid" name="groupid" value="{$groups_item.ID}" onclick="document.getElementById('sel_groupid').value=this.value;document.getElementById('sel_userid').value='';show_users(this.value,this.checked,document.getElementById('sel_moduleid').value);"></td>
        <td>{$groups_item.Name}</td>
      </tr>
      {/foreach}
      </tbody>
    </table>
    </div>
    <script type="text/javascript">
      initTableWidget('myTable',"270","300",Array('S'));
    </script>