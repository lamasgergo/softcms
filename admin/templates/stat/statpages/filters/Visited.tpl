<table class="content">
  <tr valign="middle">
    <td>{$prefix|cat:"_visited"|lang}:</td>
    <td>
    	&nbsp;{lang visited_from}&nbsp;<input id="VisitedFrom" name="VisitedFrom" class="form_item" style="width: 75px;">
		<img src="/source/images/calendar/calendar.jpg" height="20" style="vertical-align: middle;" onclick="displayCalendar(xajax.$('VisitedFrom'),'yyyy.mm.dd',this);">
		
		&nbsp;{lang visited_to}&nbsp;<input id="VisitedTo" name="VisitedTo" class="form_item" style="width: 75px;">
		<img src="/source/images/calendar/calendar.jpg" height="20" style="vertical-align: middle;" onclick="displayCalendar(xajax.$('VisitedTo'),'yyyy.mm.dd',this);">
		<input type="button" name="filter" id="filter" class="form_but" onClick="{$tab_prefix}_filter('Visited', document.getElementById('VisitedFrom').value, document.getElementById('VisitedTo').value);" value="{$prefix|cat:"_filter"|lang}">
    </td>
    
  </tr>
  <tr>
  	<td colspan="2" align="center">{lang auto_shop_date_format}({lang auto_shop_year}.{lang auto_shop_month}.{lang auto_shop_day})</td>
  </tr>
</table>




