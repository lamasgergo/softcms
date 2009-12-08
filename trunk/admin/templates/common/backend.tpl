{literal}
<script>
	$(document).ready(function(){
		$('#backend > ul').tabs({
			add: function(e, ui) {
				$(this).tabs('select', '#' + ui.panel.id);
			},
		});
	});
</script>
{/literal}
<div id="backend">
<ul>
{foreach from=$objects item=object}
	<li>
		<a href="#{$object.name}">
			<span>{$module|cat:"_"|cat:$object.name|lang}</span>
		</a>
	</li>
{/foreach}
</ul>

{foreach from=$objects item=object}
	<div id="{$object.name}">
		<div>{$object.menu}</div>
		{$object.data}
	</div>
{/foreach}

</div>