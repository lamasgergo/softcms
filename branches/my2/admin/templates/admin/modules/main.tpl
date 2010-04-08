<div id="backend">
	<ul>
	  {foreach from=$tabs item=tab}
		<li><a href="#{"tab_"|cat:$tab.name}">{$module|cat:'_'|cat:$tab.name|lang}</a></li>
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
        form_skining(ui.panel);
        NFInit();
    }
  });

</script>
{/literal}
