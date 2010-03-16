<script type="text/javascript" src="{$js}/sort_table.js"></script>
<link type="text/css" rel="StyleSheet" href="{$css}/sort_table.css" />

<link rel="stylesheet" href="{$css}/tab-view.css" type="text/css" media="screen">
<script type="text/javascript" src="{$js}/tab-view.js"></script>

<div id="dhtmlgoodies_tabView1">

  <div class="dhtmlgoodies_aTab">
    {$groups_menu}
    {$GROUPS}
  </div>

  <div class="dhtmlgoodies_aTab">
    {$users_menu}
    {$USERS}
  </div>
</div>

<script type="text/javascript">
  initTabs('dhtmlgoodies_tabView1',Array('{lang manage_groups}','{lang manage_users}'),0,800,500);
</script>
