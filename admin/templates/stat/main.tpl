<script type="text/javascript" src="{$js}/sort_table.js"></script>
<link type="text/css" rel="StyleSheet" href="{$css}/sort_table.css" />
<link rel="stylesheet" href="{$css}/dhtmlgoodies_calendar.css" type="text/css">
<script src="{$js}/dhtmlgoodies_calendar.js" type="text/javascript"></script>

<link rel="stylesheet" href="{$css}/tab-view.css" type="text/css" media="screen">
<script type="text/javascript" src="{$js}/tab-view.js"></script>


<div id="dhtmlgoodies_tabView1">

  {foreach from=$tabs item=tab}
  <div class="dhtmlgoodies_aTab">
    <table class="content" width="100%">
    <tr>
    <td id="{"visualmenu_"|cat:$tab.name}"">{$tab.menu}</td>
    <td align="right">{$tab.filter}</td>
    </tr>
    </table>
    <div id="{"visual_"|cat:$tab.name}">
      {$tab.value}
    </div>
  </div>
  {/foreach}

</div>

<script type="text/javascript">
  initTabs('dhtmlgoodies_tabView1',Array({$tabs_names}),0,800,500);
</script>
