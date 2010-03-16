
{assign var="i" value=1}

<div id="galleryList">
{foreach from=$item_arr item=item}
	<div id="item">
	
	
		<table class="content" cellpadding="0" cellspacing="0">
		<tr class="head"><td class="hleft"></td><td class="hmiddle"></td><td class="hright"></td></tr>
		<tr class="body"><td class="bleft"></td><td class="bmiddle">{show_image dir=$uploadDir dirURL=$uploadDirURL group=$item.ImageGroupID url="/index.php?mod=gallery&id="|cat:$item.ID count=1 width=115 orig=false}</td><td class="bright"></td></tr>
		<tr class="foot"><td class="fleft"></td><td class="fmiddle"></td><td class="fright"></td></tr>
		</table>

	</div>
	
	{if $i==2}
		<div class="clr"></div>
		{assign var="i" value=0}
	{/if}
	
	{assign var="i" value=$i+1}
{/foreach}
</div>
<div class="clr"></div>
<div id="galleryNav">
	{$gallery_nav}
</div>

{literal}
<script language="javascript">
	$(document).ready(function(){
		$('#galleryList').find('img').each(function(){
			$(this).hover(
				function(){
					var $img = $('<img border="0" />');
					$img.css('max-width', '404px');
					$img.attr('src', $(this).attr('id'));
					$('#galleryPreview').html($img);
				},
				function(){
					$('#galleryPreview').html('');
				}
			);
		});
	});
	
</script>
{/literal}