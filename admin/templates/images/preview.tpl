{foreach from=$images_arr item=item}
<div style='padding:3px; float: left;' id='{$item.Name}'>
      <img src='{$image_path}/{$item.ImageResize}' border='0' title='{$item.Name}' alt='{$item.Name}' border='0'>
<div>
<a href='{$image_path}/{$item.Image}' target='preview'><img src='/source/images/fileupload/image_orig.gif' border='0' width='19'></a>
  <img src='/source/images/fileupload/image_del.gif' border='0' width='19' onclick='delete_image("{$item.ID}","{$uploadDir}");'>
</div>
</div>
{/foreach}