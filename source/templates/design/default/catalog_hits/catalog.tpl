<div id="catalog">

	<div id="breadcrumbs">
		{$breadcrumbs}
	</div>
	<div class="clr"></div>
	
	<div id="catalogs">
		{$catalogs}
	</div>

	<div class="clr"></div>

	<div id="catalogItems">
	  {$items}
	</div>
	
</div>

{literal}
<script>
	$(document).ready(function(){
		
		$(document).find('#catalogItems .item').each(function(){
			$(this).replaceWith(replaceWidthBox($(this).html()));
		});
	});
	
	function replaceWidthBox(data){
		$box = $('<table class="dataBox" cellpadding="0" cellspacing="0"></table>');
		$('<tr><td class="topLeft"></td><td class="topCenter"></td><td class="topRight"></td></tr>').appendTo($box);
		$('<tr><td class="middleLeft"></td><td class="middleCenter">'+data+'</td><td class="middleRight"></td></tr>').appendTo($box);
		$('<tr><td class="bottomLeft"></td><td class="bottomCenter"></td><td class="bottomRight"></td></tr>').appendTo($box);
		return $box;
	}
</script>
{/literal}