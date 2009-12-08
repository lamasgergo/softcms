<script type="text/javascript" src="{$js}/jquery/plugins/jcarousel/lib/jquery.jcarousel.pack.js"></script>
<link rel="stylesheet" type="text/css" href="{$js}/jquery/plugins/jcarousel/lib/jquery.jcarousel.css" />
<link rel="stylesheet" type="text/css" href="{$js}/jquery/plugins/jcarousel/skins/diesel/skin.css" />
{literal}
<script type="text/javascript">
	$(document).ready(function() {
    	$('#mycarousel').jcarousel({});
	});
</script>
{/literal}

<div id="menu_top">
  
  	<div class="icon small" style="float:left; padding: 3px;">
		<a href="/admin/"><img src="{$images}/icons/home.png" border="0"></a>
		<br>
		{"Dashboard"|lang}
	</div>
	<ul id="mycarousel" class="jcarousel-skin-diesel">
		{foreach from=$top_menu item=item}
		<li>
	        {if $item.Icon ne ""}
	        <div class="icon small" style="float:left;">
	          <a href="{mod_admin_link value=$item.Link}">
	            <img src="{$images}/icons/small/{$item.Icon}" border="0">
	            <br>
	            {$item.Name|lang}
	          </a>
	        {else}
	          <a href="{mod_link value=$item.Link}">
	            <img src="{$images}/icons/noimage.png" border="0">
	            <br>
	            {$item.Name|lang}
	          </a>
	        {/if}
	        </div>
		</li>
		{/foreach}
	</ul>
	
	<div class="user">
		({$username})&nbsp;<a href="{mod_admin_common_link value='logout'}" style="color:black;">{lang logout}</a>
	</div>
	
</div>