  {if $modules ne ""}
    
    {assign var="cat" value=""}
    <p>
    <div id="mod_menu">
    {foreach name=mod from=$modules item=module}
    {if $smarty.foreach.mod.first}
    	<div class="title">{$module.ModGroup|lang}</div>
    {/if}
	    <div class="icon" style="float:left;">
	        {if $module.Icon ne ""}
	          <a href="{mod_admin_link value=$module.Link}">
	            <img src="{$images}/icons/{$module.Icon}" border="0">
	            <br>
	            {$module.Name|lang}
	          </a>
	        {else}
	          <a href="{mod_link value=$module.Link}">
	            <img src="{$images}/icons/noimage.png" border="0">
	            <br>
	            {$module.Name|lang}
	          </a>
	        {/if}
	     </div>
    {/foreach}
    </div>
    </p>
  {/if}
