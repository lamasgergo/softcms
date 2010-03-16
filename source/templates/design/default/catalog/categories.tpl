<table border="0" cellpadding="0" cellspacing="8" width="100%" id="subcataloglist">
{foreach from=$item_arr item=item name=list}
{math assign="devider" equation="x % y" x=$smarty.foreach.list.iteration y=2 }
{if $smarty.foreach.list.first}<tr valign="top">{/if}
<td width="50%">
	<div class="item">
          <div class="name">
              <a href="{$smarty.server.REQUEST_URI}/{$item.LinkAlias}">{$item.Name}</a>
          </div>
          {if $item.ImageGroupID}
          <div class="image">
            {show_image dir=$uploadDir dirURL=$uploadDirURL href=$smarty.server.REQUEST_URI|cat:"/"|cat:$item.LinkAlias group=$item.ImageGroupID class="im"}
          </div>
          {/if}
          <div class="details">
           <div class="subcatalog">          
              {foreach from=$subcatalogs_arr[$item.ID] item=citem name=clist}
                <a href="{$smarty.server.REQUEST_URI}/{$item.LinkAlias}/{$citem.LinkAlias}">{$citem.Name}</a>
                {if !$smarty.foreach.clist.last}
                &nbsp;|&nbsp;
                {/if}
              {/foreach}
           </div>
          </div>
      </div>
</td>
{if  $devider eq 0}</tr><tr velign="top">{/if}
{if $smarty.foreach.list.last}</tr>{/if}
{/foreach}
</table>