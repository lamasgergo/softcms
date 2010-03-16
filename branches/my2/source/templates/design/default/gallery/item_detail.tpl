<link rel="stylesheet" href="{$design_css}/image-slideshow.css" type="text/css" media="screen">
<script type="text/javascript" src="{$design_js}/image-slideshow.js"></script>

<div id="fakeGallery">
	<div id="itemDetails">
		<div id="itemImage">
			{image_hor_slider dir=$uploadDir dirURL=$uploadDirURL ImageGroupID=$item_arr[0].ImageGroupID count=3 width=94 rows=1 show_link=true}
		</div>
		
		<div id="itemDetailsText">
		<h3>{$item_arr[0].Name}</h3>
		<br />
		{$item_arr[0].Description|regex_replace:"/\r?\n/":"<br />"}
		</div>
	</div>
</div>

<div class="clr"></div>

{literal}
<script language="javascript">
	initSlideShow();
	$(document).ready(function(){
		$('.leftBlock').css('width', '766px');
		$('#galleryPreview').css('width', '766px').css('height','100%');
		$('#galleryPreview').html($('#fakeGallery').html());
		$('#fakeGallery').empty();
		$('#footer').empty();
	});
</script>
{/literal}