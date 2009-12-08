{literal}
<script>
	$(document).ready(function(){
		$('.tablesorter').each(function(){
			var tableID = $(this).attr('id');
			var module = tableID.replace("Table",'');
			$(this).tablesorter({widgets: ['zebra']})
			.tablesorterPager({container: $("#"+module+"_pager")});
		});
	});
</script>
{/literal}

    <form method="post" action="javascript:return false;" name="{$module}">
    
    <table id="{$module}Table" class="tablesorter">
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
	          	<td>{tablePlugin item=$item.$body module=$module}</td>
	         {/foreach}
        </tr>
      {/foreach}
      </tbody>
    </table>
    <div id="{$module}_pager" class="pager">
			<img src="{$js}/jquery/plugins/tablesorter/addons/pager/icons/first.png" class="first"/>
			<img src="{$js}/jquery/plugins/tablesorter/addons/pager/icons/prev.png" class="prev"/>
			<input type="text" class="pagedisplay"/>
			<img src="{$js}/jquery/plugins/tablesorter/addons/pager/icons/next.png" class="next"/>
			<img src="{$js}/jquery/plugins/tablesorter/addons/pager/icons/last.png" class="last"/>
			<select class="pagesize">
				<option value="2">2</option>
				<option selected="selected"  value="10">10</option>
				<option value="20">20</option>
				<option value="30">30</option>
				<option  value="40">40</option>
			</select>
	</div>
    
    </form>

