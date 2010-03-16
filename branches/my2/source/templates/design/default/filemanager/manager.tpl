{if $is_auth}
<link rel="stylesheet" href="/source/templates/design/default/filemanager/css/tree_component.css" type="text/css" >
<script type="text/javascript" src="{$js}/jquery/jquery.js"></script>
<script type="text/javascript" src="{$js}/jquery/ui/jquery.ui.all.js"></script>

<script type="text/javascript" src="/source/templates/design/default/filemanager/js/jquery.listen.js"></script>
<script type="text/javascript" src="/source/templates/design/default/filemanager/js/tree_component.js"></script>

{literal}
<style type="text/css">
fieldset{
	margin: 20px 0px;
}
#actions{
	float: left;
	min-width: 29%;
	width: 29%;
}
#fields{
	float: left;
	min-width: 70%;
	width: 70%;
}

</style>

<script type="text/javascript">

	var root = '{/literal}{$http_root}{literal}';

	function setPath(name, path, dir){
		$('#form').slideDown('slow');
		$('#path').val(path);
		$('#form').find('legend').html(name);
		$('#type').val(dir==true?'dir':'file');
		
		var dir_actions = ['create_subfolder','upload_file','delete'];
		var file_actions = ['download','delete'];
		
		$('#actions').find(':input[name=action]').attr('disabled','true');
		
		var link = "http://" + root + "/" + path;
		$('#download_link').attr('href', link);
		
		if(dir==true){
			for (i in dir_actions){
				$('#actions').find(':input[value='+dir_actions[i]+']').removeAttr('disabled');
			}
		} else {
			for (i in file_actions){
				$('#actions').find(':input[value='+file_actions[i]+']').removeAttr('disabled');
			}
		}
		
	}

    $(function() {
      tree1 = new tree_component();
      tree1.init($("#tree"), {
		ui : { animation : 500, rtl : false, dots : true }
	  });
    });
	
	$(document).ready(function(){
		$('#actions').find(':input[name=action]').click(function(){
			$('#fields').find('div').css('display','none');
			$('#fields').find('div[id='+this.value+']').css('display','');
		});
	});
 </script>
{/literal}

<div id="form" style="display:none;">
	<fieldset>
		<legend></legend>
	
	<form method="post" enctype="multipart/form-data">
		<div id="actions">
			<input type="radio" name="action" value="create_subfolder" /> {"Create Subfolder"|lang} <br />
			<input type="radio" name="action" value="upload_file" /> {"Upload File"|lang} <br />
			<input type="radio" name="action" value="download" /> {"Download"|lang} <br />
			<input type="radio" name="action" value="delete" /> {"Delete"|lang} <br />
		</div>
		<div id="fields">
			
			<div id="create_subfolder" style="display:none;">
				{"New subfolder name"|lang} : <input type="text" name="subfolder"> <br />
				<input type="submit" name="submit" value="{"Create"|lang}" />
			</div>
			<div id="upload_file" style="display:none;">
				{"File"|lang} : <input type="file" name="new_file"> <br />
				<input type="submit" name="submit" value="{"Add"|lang}" />
			</div>
			<div id="download" style="display:none;">
				<a href="#" target="_blank" id="download_link">{"Download link"}</a>
			</div>
			<div id="delete" style="display:none;">
				<input type="submit" name="submit" value="{"Yes"|lang}" />
				<input type="button" name="delete_no" value="{"No"|lang}">
			</div>
		
			<input type="hidden" name="type" id="type">
			<input type="hidden" name="path" id="path">
		</div>
	</form>
	
	</fieldset>
	
</div>

{assign var="i" value="1"}

{assign var="cur_depth" value="1"}
<div id="tree">
<ul>
{section name=item loop=$item_arr}
	<li {if !$item_arr[item].dir} class="file"{/if}>
		<a href="#" id="predef_{$i}" onClick="setPath('{$item_arr[item].name}','{$item_arr[item].path}', {if !$item_arr[item].dir}false{else}true{/if})">
			{if !$item_arr[item].dir}
				{$item_arr[item].name}
			{else}
				<span>{$item_arr[item].name}</span> 
			{/if}
		</a>
	
	{if $item_arr[item.index_next].depth > $item_arr[item].depth}
		<ul>
	{/if}
	
	
	{if $item_arr[item].depth-$item_arr[item.index_next].depth > 0}
		{section name=foo start=0 loop=$item_arr[item].depth-$item_arr[item.index_next].depth step=1}
			</ul>
			</li>
		{/section}
	{/if}
	
	{assign var="i" value=$i+1}
	{assign var="cur_depth" value=$item_arr[item].depth}
{/section}
</ul>
</div>
{else}
	{include file="error.tpl"}
{/if}