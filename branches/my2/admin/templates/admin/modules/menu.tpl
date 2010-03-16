{literal}
<script>

    function closeActiveTab(){
        var selected = $("#backend").data('selected.tabs');

    }

	function refreshTabTable( module, component, method, tabLocked){
		if (!tabLocked){
			var selected = $("#backend").data('selected.tabs');
			$("#backend").tabs('remove', selected);
			$("#backend").find('[href=#tab_'+component+']').click();
		}

		var selected = $("#backend").data('selected.tabs');
        
		var link = '/admin/ajax/index.php?mod='+module+'&class='+component+'&method=getTabContent';
		
		$.get(link, function(data){
			$('#tab_'+component).find('#grid').replaceWith(data);
		});
		
		
	};

	var lastIndex = 0;

	function addTab(title, action, module, component, id){
		if (lastIndex!=0){
			removeDynamicTabs();
		}
		lastIndex = $('#backend').tabs('length');
		var link = '/admin/ajax/index.php?mod='+module+'&class='+component+'&method='+component+'_form&action='+action;
		if (id) link += "&id="+id;

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
	
	function showAddForm(module, component){
		var title = '{/literal}{$module|cat:"_add"|lang}{literal}';
		addTab(title, 'add', module, component);
	};

	function showChangeForm(module, component){
//		var val = $("#"+component+"Grid").getGridParam("selrow");
        var val = $('div[id^=tab_]:visible').find('input[name^=actionid_]:checked').val();
		val = $.trim(val);
		if (val!='' && val!='undefined'){
			var title = '{/literal}{$module|cat:"_change"|lang}{literal}';
			addTab(title, 'change', module, component, val);
		} else {
			alert('{/literal}{"check_item_first"|lang}{literal}');
		}
	};
	

	var ids = new Array();
	function showDeleteForm(module, component){
		
//		$("#"+component+"Table").find("input:checked").each(function(){
        $('div[id^=tab_]:visible').find('input[name^=actionid_]:checked').each(function(){        
			ids.push($(this).val());
		});

        if (ids.length > 0){
            var link = '/admin/ajax/index.php?mod='+module+'&class='+component+'&method='+component+'_delete';

            $.ajax({
                type: "POST",
                url: link,
                data: {ids: ids.join(',')},
                success: function(response){
                    eval('var response = '+response+';');
                    if(typeof response =='object' || typeof response =='array'){
                        alert(response[1]);
                        result = response[0];
                    }
                    if (result){
                        refreshTabTable(module, component, method);
                    }
                }
            });

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

<a id="addButton" onClick="showAddForm('{$module}','{$tab.name}');" href='#'><img src="{$images}/menu/add.gif" border="0" /></a>
<a id="changeButton" onClick="showChangeForm('{$module}','{$tab.name}');" href='#'><img src="{$images}/menu/change.gif" border="0" /></a>
<a id="deleteButton}" onClick="showDeleteForm('{$module}','{$tab.name}');" href='#'><img src="{$images}/menu/del.gif" border="0" /></a>