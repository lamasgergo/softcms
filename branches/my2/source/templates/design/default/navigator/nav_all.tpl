<table class="navTable">
  <tr>
  	  <td>
			Страницы:
  	  </td>
      <td>
        {foreach from=$nav_arr item=item name=list}
            {$item}
            {if !$smarty.foreach.list.last}|{/if}
        {/foreach}
      </td>
  </tr>
</table>