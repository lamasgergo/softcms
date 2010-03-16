	<div id="catalogMenu">
		{foreach from=$item_arr item=item}
			<div>
				<h3 title="{$item.name}"><a href="{catalog_link category=$item.id}"><div onClick="location.ref='{catalog_link category=$item.id}';">{$item.name}</div></a></h3>
				<div>
					<ul>
						<li><img src="{$design_images}/menu-arrow.png" border="0">&nbsp;<a href="{catalog_link category=$item.id}">{$item.name}</a></li>
							<ul class="subitems">
							{foreach from=$item.childs item=child}
								<li>&nbsp;<a href="{catalog_link category=$child.id}">{$child.name}</a></li>
							{/foreach}
							</ul>
						</li>
					</ul>
				</div>
			</div>
		{/foreach}
	</div>

{literal}
<script>
	$(document).ready(function(){
		$('#catalogMenu').accordion({
			header: "h3",
			autoHeight: false
		});
		
		
		var loc = location.href.toLowerCase();
		loc = loc.replace(/http\:\/\/.+?\//,'/');
		loc = loc.replace(/[\/\/]+/g,'/');
		loc = loc.replace(/\?.*/,'');
		
		var zzz = $('#catalogMenu').find('a[href='+loc+']');
		zzz.click();
		
		
	});
</script>
{/literal}