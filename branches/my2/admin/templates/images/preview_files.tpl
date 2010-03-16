{foreach from=$images_arr item=item}
<div style='padding:3px; float: left;' id='{$item}'>
      <img src='{$image_path}/{$item}' border='0' title='{$item}' alt='{$item}' border='0' style="max-width: 140px; max-height: 140px;">
<div>
<a href='{$image_path}/{$item}' target='preview'><img src='/source/images/fileupload/image_orig.gif' border='0' width='19'></a>
<img src='/source/images/fileupload/image_del.gif' border='0' width='19' onclick='delete_image_direct("{$item}","{$uploadDir|escape:"url"}");' style="cursor: pointer;">
</div>
</div>
{/foreach}