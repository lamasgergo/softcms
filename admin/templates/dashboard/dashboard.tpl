{literal}
<script>
  $(document).ready(function(){
    $("#dashboard > ul").tabs();
  });
  
  </script>

{/literal}


<div id="dashboard">
<ul>
{foreach name=mod from=$modules_groups item=module}
		<li><a href="#{$module.ModGroup}"><span>{$module.ModGroup|lang}</span></a></li>
{/foreach}
</ul>

{foreach name=mod from=$modules_groups key="mod_key" item=module}
	<div id="{$module.ModGroup}">
		
		{foreach from=$modules[$mod_key] item=item}
		<div class="icon" style="float:left;">
	        {if $item.Icon ne ""}
	          <a href="{mod_admin_link value=$item.Link}">
	            <img src="{$images}/icons/{$item.Icon}" border="0">
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
		{/foreach} 
	</div>
{/foreach}
</div>
