<script type="text/javascript" src="{$js}/sort_table.js"></script>
<link type="text/css" rel="StyleSheet" href="{$css}/sort_table.css" />

<link rel="stylesheet" href="{$css}/tab-view.css" type="text/css" media="screen">
<script type="text/javascript" src="{$js}/tab-view.js"></script>


<div id="dhtmlgoodies_tabView1">
  <div class="dhtmlgoodies_aTab">
    <table border="0" cellpadding="0" cellspacing="15" class="content" width="90%">
    <tr>
      <td>
        {lang per_modules}
      </td>
      <td>
        {lang per_groups}
      </td>
      <td>
        {lang per_users}
      </td>
    </tr>
    <tr>
      <td>
        {$MODULES}
      </td>
      <td>
        <div id="permission_groups">
          {$GROUPS}
        </div>
      </td>
      <td>
        <div id="permission_users">
          {$USERS}
        </div>
      </td>
    </tr>
    </table>
    <input type="hidden" name="sel_moduleid" id="sel_moduleid">
    <input type="hidden" name="sel_groupid" id="sel_groupid">
    <input type="hidden" name="sel_userid" id="sel_userid">
  </div>
</div>
<div id="perm_area" style="background-color: white; width: 910px;">
</div>
<script type="text/javascript">
  initTabs('dhtmlgoodies_tabView1',Array('{lang per_modules}'),0,900,400);
</script>
