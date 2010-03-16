<table>
	<tr>
		<td align="center"><img src="{$design_images}/news_archive.gif"></td>
	</tr>
	<tr>
		<td><div id="calendar"></div></td>
	</tr>
</table>
<div class="clr"></div>



<script>
{literal}
var events_arr = [];
var dates_func_arr = [];
{/literal}			
{foreach from=$item_arr item=item}		
{literal}		
			events_arr['{/literal}{$item.news_date}{literal}'] = {click: function(td, date_str){
				  var event_date = new Date().fromString(date_str);
				  location.replace("/index.php?mod=content&cid={/literal}{$category_id}{literal}&date="+event_date.print('d-m-Y')+"&tpl=all_news&menuId="+{/literal}{$smarty.get.menuId}{literal});
		     }
			};
			
			dates_func_arr['{/literal}{$item.news_date}{literal}'] = function(td, date_str){date=new Date().fromString(date_str);td.setHTML('<span style="color:red;">'+date.print('d')+'</span>');}
{/literal}			
{/foreach}
</script>

{if $smarty.get.date}
	{assign var="selected_date" value=$smarty.get.date|date_format:"%m-%e-%Y"}
{else}
	{assign var="selected_date" value=$item.news_date}
{/if}

{literal}
  <script type="text/javascript">
			// this function is used in the internation calendar to alert the current date
			
			window.addEvent('domready', function(){
				
				var ge_cal = new Calendar("calendar", null, {inputType:"none",
										idPrefix:'cal_de',
										visible: true,
										tdEvents:events_arr,
										dateOnAvailable: dates_func_arr,
										allowDatesOffSelection: true,
										startDate:new Date().fromString('{/literal}{$item_arr[0].start_date}{literal}'),
										selectedDate:new Date().fromString('{/literal}{$selected_date}{literal}'),
										language:{
											'days':{
												'char':[{/literal}{"cal_days_char"|lang}{literal}],
												'short':[{/literal}{"cal_days_short"|lang}{literal}],
												'mid':[{/literal}{"cal_days_mid"|lang}{literal}],
												'long':[{/literal}{"cal_days_long"|lang}{literal}]
											},
											'months':{
												'short':[{/literal}{"cal_months_short"|lang}{literal}],
												'long':[{/literal}{"cal_months_long"|lang}{literal}]
											},
											'am_pm':{
												'lowerCase':[{/literal}{"cal_am_pm_l"|lang}{literal}],
												'upperCase':[{/literal}{"cal_am_pm_u"|lang}{literal}]
											}
										}
									});	
				
			});
	</script>
  {/literal}
  
 