{literal}
<script>

    function closeActiveTab(){
        var selected = $("#backend").data('selected.tabs');

    }

	function refreshTabTable(module, component, tabLocked){
		if (!tabLocked){
			var selected = $("#backend").data('selected.tabs');
			$("#backend").tabs('remove', selected);
			$("#backend").find('[href=#tab_'+component+']').click();
		}

		var selected = $("#backend").data('selected.tabs');
        
		var link = '/admin/index.php?mod='+module+'|'+component;
		
		$('#'+component+"_pager").remove();
		$.get(link, function(data){
			$('#'+component+"GridRefresh").replaceWith(data);
			jsGrid(component);
		});
		
		
	};

	var lastIndex = 0;

	function addTab(title, action, module, component, id){
		if (lastIndex!=0){
			removeDynamicTabs();
		}
		lastIndex = $('#backend').tabs('length');
		var link = '/admin/index.php?mod='+module+'|'+component+'&act='+action;
		if (id) link = link + "&id="+id;
		$('#backend').tabs("add", link, title);
        $("#backend").tabs("select", lastIndex);
	};
	
	function removeTabByTitle(title){
		var index = 0;
		$("#backend >ul").find('li').each(function(){
			if ($(this).find('span').text()==title){
				$("#backend").tabs("remove", index);
			}
			index++;
		});
	};
	function removeDynamicTabs(){
		for (i=lastIndex; i<$('#backend').tabs('length'); i++){
			$("#backend").tabs("remove", i);
		}
	};
	
	function showAddForm(component){
		var title = '{/literal}{"Add"|lang}{literal}';
		addTab(title, 'add', '{/literal}{$module}{literal}', component);
	};

	function showChangeForm(component){
		var val = $("#"+component+"Grid").getGridParam("selrow");
		val = $.trim(val);
		if (val!='' && val!='undefined'){
			var title = '{/literal}{"Change"|lang}{literal}';
			addTab(title, 'change', '{/literal}{$module}{literal}', component, val);
		} else {
			alert('{/literal}{"check_item_first"|lang}{literal}');
		}
	};
	

	var ids = new Array();
	function showDeleteForm(component){
		
		$("#"+component+"Table").find("input:checked").each(function(){
			ids.push($(this).val());
		});
		
		if (ids.length > 0){
			eval("xajax_"+component+"_delete('"+ids+"')");
		} 
		return false;
	};
	
	function addFormCallback(module, component){
		refreshTabTable(module, component);
	};
	
	function changeFormCallback(module, component, tabLocked){
		refreshTabTable(module, component, tabLocked);
	};
	function deleteFormCallback(module, component){
		refreshTabTable(module, component, true);
	};
</script>
{/literal}

<a id="addButton" onClick="showAddForm('{$component}');" href='#'><img src="{$images}/menu/add.gif" border="0" /></a>
<a id="changeButton" onClick="showChangeForm('{$component}');" href='#'><img src="{$images}/menu/change.gif" border="0" /></a>
<a id="deleteButton}" onClick="showDeleteForm('{$component}');" href='#'><img src="{$images}/menu/del.gif" border="0" /></a>