
  <div id="mod_menu">
      <ul>
      {assign var="mod_group" value=""}
      {foreach from=$modules item=module}
        {if $mod_group<>$module.ModGroup}
            <li><a href="#{$module.ModGroup}">{$module.ModGroup|lang}</a></li>
            {assign var="mod_group" value=$module.ModGroup}
        {/if}
      {/foreach}
      </ul>

      {assign var="mod_group" value=""}
      {foreach from=$modules item=module}
        {if $mod_group<>$module.ModGroup}
            {if $mod_group ne ""}
                <div style="clear: left;"></div>
                </div>
            {/if}
            <div id="{$module.ModGroup}" style="border: 1px solid;">
            {assign var="mod_group" value=$module.ModGroup}
        {/if}

        <div class="icon">
            <a href="/admin/index.php?mod={$module.Name}">
                    <img border="0" src="/admin/modules/{$module.Name}/images/{$module.Name}.png" /><br>
               {$module.Name|lang}
            </a>
        </div>
      {/foreach}
      <div style="clear: left;"></div>
  </div>

  
{literal}
  <script>
  $(document).ready(function(){
    $('#mod_menu').tabs();
  });
  </script>
{/literal}