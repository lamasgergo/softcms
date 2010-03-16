    <div id="visual_modules" class="widget_tableDiv">
    <table id="myTable">
      <thead>
        <tr>
          <td>{lang per_choose}</td>
          <td>{lang per_user}</td>
        </tr>
      </thead>
      <tbody class="scrollingContent">
      {foreach from=$users item=users_item}
      <tr>
        <td style="height:20px;"><input type="radio" id="userid" name="userid" value="{$users_item.ID}" onclick="document.getElementById('sel_userid').value=this.value; show_user_rights(document.getElementById('sel_moduleid').value,document.getElementById('sel_groupid').value,this.value);"></td>
        <td>{$users_item.Name} {$users_item.Familyname}</td>
      </tr>
      {/foreach}
      </tbody>
    </table>
    </div>
    <script type="text/javascript">
      initTableWidget('myTable',"270","300",Array('S'));
    </script>