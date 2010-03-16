<script type="text/javascript" src="{$js}/sort_table.js"></script>
<link type="text/css" rel="StyleSheet" href="{$css}/sort_table.css" />
<link rel="stylesheet" href="{$css}/dhtmlgoodies_calendar.css" type="text/css">
<script src="{$js}/dhtmlgoodies_calendar.js" type="text/javascript"></script>

<link rel="stylesheet" href="{$css}/tab-view.css" type="text/css" media="screen">
<script type="text/javascript" src="{$js}/tab-view.js"></script>

{literal}
<script>
function categoryRow(){
	var item = document.getElementById('selectCategory');
	var sel = item[item.selectedIndex];
	var text = sel.text;
	text = text.replace(/^[\s\-]/,"");
	$('#LinkCategoriesDiv').append('<div id="categoryRow_'+sel.value+'">'+text+'<img src="/source/images/properties/del.jpg" onClick="removeRow(\''+sel.value+'\')"></div>');
}

function removeRow(index){
	$('#LinkCategoriesDiv').find('#categoryRow_'+index).remove();
	var value = $('#LinkCategories').val();
	value = value.replace(/\s+/,'');
	var data = value.split(",");
	var newdata = [];
	for (i=0; i<data.length; i++){
		if (data[i]!=index) newdata.push(data[i]);
	}
	value = newdata.join(",");
	value = value.replace(/^,/,"");
	$('#LinkCategories').val(value);
}
function addCategoryLink(){
		var add = $('#selectCategory').val();
		if (add!='0'){
			var value = $('#LinkCategories').val();
			value = value.replace(/\s+/,'');
			var data = value.split(",");
			var found = false;
			for (i in data){
				if (data[i]==add) found = true;
			}
			if (found==false){
				data.push(add);
				categoryRow();
			}
			value = data.join(",");
			value = value.replace(/^,/,"");
			$('#LinkCategories').val(value);
		}
}
</script>
{/literal}

<div id="dhtmlgoodies_tabView1">

  {foreach from=$tabs item=tab}
  <div class="dhtmlgoodies_aTab">
    <table>
    <tr>
    <td>{$tab.menu}</td>
    </tr>
    </table>
    <div id="{"visual_"|cat:$tab.name}">
      {$tab.value}
    </div>
  </div>
  {/foreach}

</div>

<script type="text/javascript">
  initTabs('dhtmlgoodies_tabView1',Array({$tabs_names}),0,800,500);
</script>
<input type="hidden" name="parentActiveTabCount" id="parentActiveTabCount" value="{$tabs_count}">