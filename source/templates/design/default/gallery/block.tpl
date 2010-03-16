<div id="gallery">
	<div id="title">
		<img src="{$design_images}/gallery.gif" border="0">
	</div>
	<div id="image">
		{foreach from=$item_arr item=item}
			{if !empty($url)}
				{show_image count=$limit random=$random dir=$uploadDir dirURL=$uploadDirURL url=$url group=$item.ImageGroupID class="im" delimiter="<br /><br />"}
			{else}
				{show_image count=$limit random=$random dir=$uploadDir dirURL=$uploadDirURL href=$mod_name|cat:"&mode=details&id="|cat:$item.ID group=$item.ImageGroupID class="im" delimiter="<br /><br />"}
			{/if}
			
		{/foreach}
		
	</div>
</div>