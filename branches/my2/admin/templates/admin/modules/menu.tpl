<script type="text/javascript" src="/admin/js/toolbar.js"></script>
{literal}
<script>

	function showAddForm(module, component){
		var title = '{/literal}{$module|cat:"_add"|lang}{literal}';
		addTab(title, 'add', module, component);
	};

	function showChangeForm(module, component){
		var val = $("#"+component+"Grid").getGridParam('selrow');
		alert(val);
//        var val = $('div[id^=tab_]:visible').find('input[name^=actionid_]:checked').val();
		val = $.trim(val);
		if (val!='' && val!='undefined'){
			var title = '{/literal}{$module|cat:"_change"|lang}{literal}';
			addTab(title, 'change', module, component, val);
		} else {
			alert('{/literal}{'check_item_first'|lang}{literal}');
		}
	};
	

	var ids = new Array();
	function showDeleteForm(module, component){

        var ids = new Array();

        $("#"+component+"Grid").find('tr[aria-selected=true]').each(function(){
			ids.push($(this).attr('id'));
		});


        if (ids.length > 0){
            var link = '/admin/ajax.php?mod='+module+'&class='+component+'&method=delete';
            self.module = module;
            self.component = component;
            $.ajax({
                type: "POST",
                url: link,
                data: {ids: ids.join(',')},
                success: function(response){
                    eval('var response = '+response+';');
                    if(typeof response =='object' || typeof response =='array'){
                        alert(response[1]);
                        refreshTabTable(self.module, self.component, true);
                    }
                }
            });
        }
		return false;
	};
	
</script>
{/literal}

<a id="addButton" onClick="showAddForm('{$module}','{$tab.name}');" href='#'><img src="/admin/images/menu/add.png" border="0" /></a>
<a id="changeButton" onClick="showChangeForm('{$module}','{$tab.name}');" href='#'><img src="/admin/images/menu/change.png" border="0" /></a>
<a id="deleteButton}" onClick="showDeleteForm('{$module}','{$tab.name}');" href='#'><img src="/admin/images/menu/delete.png" border="0" /></a>