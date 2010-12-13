<link rel="stylesheet" type="text/css" href="/admin/js/jqGrid/css/ui.jqgrid.css" media="screen" />
<script type="text/javascript"  src="/admin/js/jqGrid/js/i18n/grid.locale-en.js"></script>
<script type="text/javascript"  src="/admin/js/jqGrid/js/jquery.jqGrid.min.js"></script>
<div id="backend">
	<ul>
	  {foreach from=$tabs item=tab}
		<li><a href="#{"tab_"|cat:$tab.name}">{$tab.name|lang:'ADMIN_MENU'}</a></li>
	  {/foreach}
	</ul>
    {foreach from=$tabs item=tab}
    <div id="{"tab_"|cat:$tab.name}">
		<div id="menu">
			{include file="admin/modules/menu.tpl"}
		</div>
		<div id="grid">
			{$tab.value}
		</div>
    </div>
  {/foreach}

</div>

{literal}
<script type="text/javascript">

  $('#backend').tabs({
      load: function(event, ui){
          markRequired(ui.panel);
      }
  });

</script>
{/literal}
