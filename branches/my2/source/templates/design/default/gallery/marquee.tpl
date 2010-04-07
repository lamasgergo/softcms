<div id="gallery">
	<div id="title">
		<img src="{$design_images}/gallery.gif" border="0">
	</div>
	<div id="image" style="text-align: center;">
		<marquee onMouseOver="this.stop();" onMouseOut="this.start();" height="260" width="220" direction="up" scrolldelay="20" scrollamount="2" style="margin: 6px 0px 0px; text-align: center;">
		{foreach from=$item_arr item=item}
			{show_image count=$limit random=$random dir=$uploadDir dirURL=$uploadDirURL href=$moduleName|cat:"&mode=details&id="|cat:$item.ID group=$item.ImageGroupID class="im" delimiter="<br /><br />"}
		{/foreach}
		</marquee>
	</div>
</div>