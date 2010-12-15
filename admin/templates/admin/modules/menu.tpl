<script type="text/javascript" src="/admin/js/toolbar.js"></script>
{literal}
<script>

	function showAddForm(module, component){
		var title = '{/literal}{"Add"|lang:"ADMIN_TOOLBAR"}{literal}';
		addTab(title, 'add', module, component);
	};

	function showChangeForm(module, component){
		var val = $("#"+component+"Grid").getGridParam('selrow');
//        var val = $('div[id^=tab_]:visible').find('input[name^=actionid_]:checked').val();
		val = $.trim(val);
		if (val!='' && val!='undefined'){
			var title = '{/literal}{"Change"|lang:"ADMIN_TOOLBAR"}{literal}';
			addTab(title, 'change', module, component, val);
		} else {
			showNotice('{/literal}{'Please check item first'|lang}{literal}');
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
                        showNotice(response[1]);
                        refreshTabTable(self.module, self.component, true);
                    }
                }
            });
        }
		return false;
	};
	
</script>
{/literal}
<div class="toolbar">
    <div class="actions">
        <a id="addButton" onClick="showAddForm('{$module}','{$tab.name}');" href='#'><img src="/admin/images/menu/add.png" border="0" /></a>
        <a id="changeButton" onClick="showChangeForm('{$module}','{$tab.name}');" href='#'><img src="/admin/images/menu/change.png" border="0" /></a>
        <a id="deleteButton" onClick="showDeleteForm('{$module}','{$tab.name}');" href='#'><img src="/admin/images/menu/delete.png" border="0" /></a>
    </div>
    <div class="language ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
        {"Edit language:"|lang:"ADMIN_TOOLBAR"}
        <select name="editLang">
            {html_options options=Access::getAllowedLanguagesList($module, 'modify') selected=User::getInstance()->get('EditLang')}
        </select>
    </div>
</div>