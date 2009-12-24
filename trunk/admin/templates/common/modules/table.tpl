{literal}
<script>
	$(document).ready(function(){
         //$('.grid').jqGrid();
         tableToGrid($('#{/literal}{$module}{literal}Grid'), {
             width: $('#backend').find('.ui-tabs-panel').width(),
             height: 'auto',
             rowNum:20,
             rowList:[10,20,30],
             pager: '#{/literal}{$module}{literal}GridPager',
             emptyrecords: "No records to view"
         });
	});
</script>
{/literal}

    <form method="post" action="javascript:return false;" name="{$module}">
    
    <table id="{$module}Grid" class="grid">
      <thead>
      	<tr>
		<th>{$module|cat:'_action'|lang}</th>
      	{foreach from=$columns item=header}
      		<th>{$module|cat:'_'|cat:$header|lang}</th>
      	{/foreach}
        </tr>
      </thead>
      <tbody>
      {foreach name=grid from=$items_arr item=item}
        <tr>
			<td style="height:20px; width: 20px;"><input type="checkbox" name="actionid_{$item.ID}" value="{$item.ID}"></td>
        	{foreach name=grid from=$columns item=body}
	          	<td>{$item.$body}</td>
	        {/foreach}
        </tr>
      {/foreach}
      </tbody>
    </table>
    <div id="{$module}GridPager"></div>

    </form>

