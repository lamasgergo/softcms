<script type="text/javascript" src="{$js}/sort_table.js"></script>
<link type="text/css" rel="StyleSheet" href="{$css}/sort_table.css" />

<link rel="stylesheet" href="{$css}/tab-view.css" type="text/css" media="screen">
<script type="text/javascript" src="{$js}/tab-view.js"></script>


<div id="dhtmlgoodies_tabView1">

  <div class="dhtmlgoodies_aTab">
    {$category_menu}
    <div id="visual_categories">
    {$CATEGORIES}
    </div>
  </div>

  <div class="dhtmlgoodies_aTab">
    {$item_menu}
    <div id="visual_items">
    {$ITEMS}
    </div>
  </div>


</div>

<script type="text/javascript">
  initTabs('dhtmlgoodies_tabView1',Array('{lang cnt_categories}','{lang cnt_items}'),0,800,500);
</script>
