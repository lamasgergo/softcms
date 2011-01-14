<div id="backend">
	<ul>
	  {foreach from=$tabs item=tab}
		<li><a href="#{"tab_"|cat:$tab.name}">{$tab.name|lang}</a></li>
	  {/foreach}
	</ul>
  {foreach from=$tabs item=tab}
    <div id="{"tab_"|cat:$tab.name}">
		<div id="menu">
			{$tab.menu}
		</div>
		<div>
			{$tab.value}
		</div>
    </div>
  {/foreach}

</div>

<script type="text/javascript">

  $('#backend').tabs();

</script>
